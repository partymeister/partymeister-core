<?php

namespace Partymeister\Core\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Motor\Backend\Models\Category;
use Motor\Backend\Models\User;
use Partymeister\Core\Models\Guest;

/**
 * Class PartymeisterCoreImportTicketsCommand
 *
 * @package Partymeister\Core\Console\Commands
 */
class PartymeisterCoreImportTicketsCSVCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'partymeister:core:import:tickets:csv {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import CSV from deinetickets.de';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Auth::login(User::find(1));

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
