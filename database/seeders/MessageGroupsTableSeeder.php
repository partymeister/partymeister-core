<?php

namespace Partymeister\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Motor\Backend\Models\User;

/**
 * Class AccountsTableSeeder
 * @package Partymeister\Accounting\Database\Seeds
 */
class MessageGroupsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('message_groups')->insert([
            'name'       => 'Organizer',
            'uuid'       => uniqid(),
            'created_by' => User::get()->first()->id,
            'updated_by' => User::get()->first()->id,
        ]);

        DB::table('message_group_user')->insert([
            'message_group_id' => \Partymeister\Core\Models\MessageGroup::first()->id,
            'user_id'          => User::first()->id,
        ]);
    }
}
