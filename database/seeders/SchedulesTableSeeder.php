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
class SchedulesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('schedules')->insert([
            'name'       => 'Main Schedule',
            'created_by' => User::get()->first()->id,
            'updated_by' => User::get()->first()->id,
        ]);
    }
}
