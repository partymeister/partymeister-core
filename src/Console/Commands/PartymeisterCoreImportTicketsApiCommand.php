<?php

namespace Partymeister\Core\Console\Commands;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Motor\Backend\Models\Category;
use Motor\Backend\Models\User;
use Partymeister\Competitions\Models\AccessKey;
use Partymeister\Core\Models\Guest;

/**
 * Class PartymeisterCoreImportTicketsCommand
 *
 * @package Partymeister\Core\Console\Commands
 */
class PartymeisterCoreImportTicketsApiCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'partymeister:core:import:tickets:api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import from deinetickets.de API';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Auth::login(User::find(1));

        $loginClient = new Client([
            'verify' => false,
        ]);

        $loginRequest = new Request('POST', config('partymeister-core-dt.base_url').'/user/login', ['content-type' => 'application/json'], json_encode([
            'email'    => config('partymeister-core-dt.email'),
            'password' => config('partymeister-core-dt.password'),
        ]));

        try {
            $loginResponse = $loginClient->send($loginRequest);
            $token = Arr::get(json_decode((string) $loginResponse->getBody(), true), 'token');

            $client = new Client([
                'verify' => false,
            ]);

            $request = new Request('GET', config('partymeister-core-dt.base_url').'/order/getAll', [
                'content-type' => 'application/json',
                'X-Shop'       => config('partymeister-core-dt.shop'),
                'X-Token'      => $token,
            ]);

            try {
                $response = $client->send($request);
                $data = json_decode((string) $response->getBody(), true);
                $count = 0;
                $amount = 0;

                foreach ($data as $order) {
                    if (strtotime(Arr::get($order, 'Bestelldatum')) > strtotime('2020-03-23 00:00:00') && Arr::get($order, 'Storniert') == '0' && Arr::get($order, 'Bezahlt') != '0') {
                        //$this->info('Order: '.Arr::get($order, 'Betreff').' is valid');

                        // Check shopping cart for a valid ticket (t-shirts don't count)
                        foreach (Arr::get($order, 'Warenkorb') as $item) {
                            if (strpos(Arr::get($item, 'Name'), 'T-Shirt') === false) {
                                $amount += ((int) Arr::get($item, 'Preis') * (int) Arr::get($item, 'Menge'));
                                foreach (Arr::get($item, 'Keys', []) as $key) {
                                    $count++;

                                    // Check if we already imported this key
                                    $existingAccessKey = AccessKey::where('access_key', $key)
                                                                  ->first();
                                    if (is_null($existingAccessKey)) {
                                        $accessKey = new AccessKey();
                                        $accessKey->access_key = $key;
                                        $accessKey->save();
                                        $this->info('Code: '.$key.' ('.Arr::get($item, 'Name').')');
                                    } else {
                                        $this->info('Code '.$key.' skipped');
                                    }
                                }
                            }
                        }
                    }
                }
                $this->info('Tickets: '.$count);
                $this->info('Amount: '.$amount);
            } catch (\Exception $e) {
                dd($e->getMessage());
                Log::warning($e->getMessage());
            }
        } catch (\Exception $e) {
            Log::warning($e->getMessage());
        }
        dd("ENDE");

        // Open file
        if (($handle = fopen($this->argument('file'), 'r')) !== false) {
            // Read every row and save it in the database, skipping already existing codes
            while (($row = fgetcsv($handle, 2048, ';')) !== false) {
                // Skip header
                if ($row[0] == 'id') {
                    continue;
                }

                $record = Guest::where('ticket_code', utf8_encode($row[20]))
                               ->first();
                if (! is_null($record)) {
                    $this->info('Skip ticket '.utf8_encode($row[20]));
                    continue;
                }

                $category = Category::where('scope', 'guest')
                                    ->where('name', utf8_encode($row[19]))
                                    ->first();
                if (is_null($category)) {
                    // Get root
                    $root = Category::where('scope', 'guest')
                                    ->where('_lft', 1)
                                    ->first();

                    $category = new Category();
                    $category->name = utf8_encode($row[19]);
                    $category->scope = 'guest';
                    $category->appendToNode($root)
                             ->save();
                }

                // Save row
                $record = new Guest();
                $record->ticket_order_number = $row[1];
                $record->company = utf8_encode($row[2]);
                $record->name = utf8_encode($row[4].' '.$row[5]);
                $record->country = utf8_encode($row[9]);
                $record->email = utf8_encode($row[10]);
                $record->ticket_type = $row[19];
                $record->ticket_code = $row[20];
                $record->category_id = $category->id;

                $record->save();

                $this->info('Added ticket '.$row[20]);
            }
            fclose($handle);
        }
    }
}
