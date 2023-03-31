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

                // Access key loop
                foreach ($data as $order) {

                    if (Arr::get($order, 'Storniert') == '0' && Arr::get($order, 'Bezahlt') != '0') {
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

                                        if (strpos(Arr::get($item, 'Name'), 'Remote') !== false) {
                                            $accessKey->is_remote = true;
                                        }
                                        $accessKey->is_prepaid = true;

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

                // Guest list loop
                foreach ($data as $order) {
                    if (Arr::get($order, 'Storniert') != '0' || Arr::get($order, 'Bezahlt') == '0' || (int)Arr::get($order, 'Versand') > 0) {
                        continue;
                    }

                    if (count(Arr::get($order, 'Warenkorb')) > 1) {
                        $this->info($order['Betreff'] . ' has more than one item');
                    }

                    foreach (Arr::get($order, 'Warenkorb') as $item) {

                        // Filter out remote tickets
                        if (strpos(strtolower(Arr::get($item, 'Name')), 'remote') !== false) {
                            $this->info('Skipping remote ticket');
                            continue;
                        }

                        if (Arr::get($item, 'Keys')) {
                            foreach (Arr::get($item, 'Keys') as $key) {
                                $record = Guest::where('ticket_code', $key)
                                               ->first();
                                if (! is_null($record)) {
                                    $this->info('Ticket '.$key.' exists - overwriting');
                                } else {
                                    $record = new Guest();
                                }

                                $category = Category::where('scope', 'guest')
                                                    ->where('name', $item['Name'])
                                                    ->first();

                                if (is_null($category)) {
                                    // Get root
                                    $root = Category::where('scope', 'guest')
                                                    ->where('_lft', 1)
                                                    ->first();

                                    $category = new Category();
                                    $category->name = $item['Name'];
                                    $category->scope = 'guest';
                                    $category->appendToNode($root)
                                             ->save();
                                }

                                if (Arr::get($item, 'Discounts')) {
                                    $record->comment = implode(', ', $item['Discounts']);
                                }

                                $record->ticket_order_number = $order['Betreff'];
                                $record->company = $order['Firma'];
                                $record->name = $order['Vorname'].' '.$order['Nachname'];
                                $record->country = $order['Land'];
                                $record->email = $order['Email'];
                                $record->ticket_type = $item['Name'];
                                $record->ticket_code = $key;
                                $record->category_id = $category->id;

                                $record->save();
                            }

                            //$this->info('keys found!');
                        } else {
                            $this->error($order['Betreff'] . ' - '.$item['Name']. ' - '. $order['Versandart']);
                        }

                    }
                }


            } catch (\Exception $e) {
                Log::warning($e->getMessage());
            }
        } catch (\Exception $e) {
            Log::warning($e->getMessage());
        }
    }
}
