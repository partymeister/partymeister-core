<?php

namespace Partymeister\Core\Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Class AccountsTableSeeder
 */
class PartymeisterCoreDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
            [
                SchedulesTableSeeder::class,
                EventTypesTableSeeder::class,
                EventsTableSeeder::class,
                MessageGroupsTableSeeder::class,
                ConfigVariablesTableSeeder::class,
            ]
        );
    }
}
