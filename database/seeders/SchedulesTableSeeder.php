<?php

namespace Partymeister\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Motor\Admin\Models\User;

/**
 * Class AccountsTableSeeder
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
