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
class ConfigVariablesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('config_variables')->insert([
            'package'    => 'motor-backend',
            'group'      => 'motor-backend-project',
            'name'       => 'name',
            'value'      => 'Partymeister 3.0',
            'created_by' => User::get()->first()->id,
            'updated_by' => User::get()->first()->id,
        ]);

        DB::table('config_variables')->insert([
            'package'    => 'motor-backend',
            'group'      => 'motor-backend-project',
            'name'       => 'name_frontend',
            'value'      => 'Random Demoparty',
            'created_by' => User::get()->first()->id,
            'updated_by' => User::get()->first()->id,
        ]);

        DB::table('config_variables')->insert([
            'package'    => 'partymeister-competitions',
            'group'      => 'partymeister-competitions-voting',
            'name'       => 'deadline',
            'value'      => '2019-12-31 23:59:59',
            'created_by' => User::get()->first()->id,
            'updated_by' => User::get()->first()->id,
        ]);
    }
}
