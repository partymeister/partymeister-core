<?php

namespace Partymeister\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Motor\Backend\Models\User;
use Partymeister\Accounting\Models\AccountType;

/**
 * Class AccountsTableSeeder
 * @package Partymeister\Accounting\Database\Seeds
 */
class EventTypesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('event_types')->insert([
            'name'        => 'Competition',
            'web_color'   => 'rgba(99, 168, 72, 1)',
            'slide_color' => 'rgba(60, 105, 44, 1)',
            'created_by'  => User::get()->first()->id,
            'updated_by'  => User::get()->first()->id,
        ]);

        DB::table('event_types')->insert([
            'name'        => 'Deadline',
            'web_color'   => 'rgba(229, 85, 74, 1)',
            'slide_color' => 'rgba(229, 85, 74, 1)',
            'created_by'  => User::get()->first()->id,
            'updated_by'  => User::get()->first()->id,
        ]);

        DB::table('event_types')->insert([
            'name'        => 'Event',
            'web_color'   => 'rgba(250, 208, 40, 1)',
            'slide_color' => 'rgba(250, 208, 40, 1)',
            'created_by'  => User::get()->first()->id,
            'updated_by'  => User::get()->first()->id,
        ]);

        DB::table('event_types')->insert([
            'name'        => 'Demoshow',
            'web_color'   => 'rgba(136, 187, 255, 1)',
            'slide_color' => 'rgba(136, 187, 255, 1)',
            'created_by'  => User::get()->first()->id,
            'updated_by'  => User::get()->first()->id,
        ]);

        DB::table('event_types')->insert([
            'name'        => 'Live Act',
            'web_color'   => 'rgba(240, 214, 110, 1)',
            'slide_color' => 'rgba(240, 214, 110, 1)',
            'created_by'  => User::get()->first()->id,
            'updated_by'  => User::get()->first()->id,
        ]);

        DB::table('event_types')->insert([
            'name'        => 'Seminar',
            'web_color'   => 'rgba(240, 214, 110, 1)',
            'slide_color' => 'rgba(240, 214, 110, 1)',
            'created_by'  => User::get()->first()->id,
            'updated_by'  => User::get()->first()->id,
        ]);

        DB::table('event_types')->insert([
            'name'        => 'Concert',
            'web_color'   => 'rgba(240, 214, 110, 1)',
            'slide_color' => 'rgba(240, 214, 110, 1)',
            'created_by'  => User::get()->first()->id,
            'updated_by'  => User::get()->first()->id,
        ]);

        DB::table('event_types')->insert([
            'name'        => 'Organizer Only',
            'web_color'   => 'rgba(255, 255, 255, 1)',
            'slide_color' => 'rgba(255, 255, 255, 1)',
            'created_by'  => User::get()->first()->id,
            'updated_by'  => User::get()->first()->id,
        ]);

        DB::table('event_types')->insert([
            'name'        => 'Shuttles',
            'web_color'   => 'rgba(54, 108, 255, 1)',
            'slide_color' => 'rgba(54, 108, 255, 1)',
            'created_by'  => User::get()->first()->id,
            'updated_by'  => User::get()->first()->id,
        ]);

        DB::table('event_types')->insert([
            'name'        => '2nd Stage',
            'web_color'   => 'rgba(240, 214, 110, 1)',
            'slide_color' => 'rgba(240, 214, 110, 1)',
            'created_by'  => User::get()->first()->id,
            'updated_by'  => User::get()->first()->id,
        ]);
    }
}
