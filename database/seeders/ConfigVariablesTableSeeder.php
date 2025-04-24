<?php

namespace Partymeister\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Motor\Backend\Models\User;

/**
 * Class AccountsTableSeeder
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
            'package' => 'motor-backend',
            'group' => 'motor-backend-project',
            'name' => 'name',
            'value' => 'Partymeister 3.0',
            'created_by' => User::get()->first()->id,
            'updated_by' => User::get()->first()->id,
        ]);

        DB::table('config_variables')->insert([
            'package' => 'motor-cms',
            'group' => 'motor-cms-frontend',
            'name' => 'name',
            'value' => 'Random Demoparty',
            'created_by' => User::get()->first()->id,
            'updated_by' => User::get()->first()->id,
        ]);

        DB::table('config_variables')->insert([
            'package' => 'partymeister-frontend',
            'group' => 'partymeister-frontend',
            'name' => 'css',
            'value' => '/* INSERT YOUR CUSTOM CSS HERE */',
            'created_by' => User::get()->first()->id,
            'updated_by' => User::get()->first()->id,
        ]);

        DB::table('config_variables')->insert([
            'package' => 'partymeister-competitions',
            'group' => 'partymeister-competitions-voting',
            'name' => 'deadline',
            'value' => date('Y').'-12-31 23:59:59',
            'created_by' => User::get()->first()->id,
            'updated_by' => User::get()->first()->id,
        ]);

        DB::table('config_variables')->insert([
            'package' => 'partymeister-competitions',
            'group' => 'partymeister-competitions-voting',
            'name' => 'live-refresh-interval',
            'value' => '20000',
            'created_by' => User::get()->first()->id,
            'updated_by' => User::get()->first()->id,
        ]);
    }
}
