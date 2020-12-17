<?php

namespace Partymeister\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Motor\Backend\Models\User;
use Partymeister\Accounting\Models\AccountType;
use Partymeister\Core\Models\EventType;
use Partymeister\Core\Models\Schedule;

/**
 * Class AccountsTableSeeder
 * @package Partymeister\Accounting\Database\Seeds
 */
class EventsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->insert([
            'schedule_id'   => Schedule::first()->id,
            'event_type_id' => EventType::where('name', 'Event')->first()->id,
            'name'          => 'Doors open',
            'starts_at'     => date('Y-m-d').' 14:00:00',
            'is_visible'    => true,
            'sort_position' => 10,
            'created_by'    => User::get()->first()->id,
            'updated_by'    => User::get()->first()->id,
        ]);

        DB::table('events')->insert([
            'schedule_id'   => Schedule::first()->id,
            'event_type_id' => EventType::where('name', 'Event')->first()->id,
            'name'          => 'Doors close',
            'starts_at'     => date('Y-m-d').' 22:00:00',
            'is_visible'    => true,
            'sort_position' => 10,
            'created_by'    => User::get()->first()->id,
            'updated_by'    => User::get()->first()->id,
        ]);
    }
}
