<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Partymeister\Core\Models\MessageGroup;

class PartymeisterCoreBackendMessageGroupTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    protected $readPermission;

    protected $writePermission;

    protected $deletePermission;

    protected $tables = [
        'message_groups',
        'users',
        'languages',
        'clients',
        'permissions',
        'roles',
        'model_has_permissions',
        'model_has_roles',
        'role_has_permissions',
        'media'
    ];


    public function setUp()
    {
        parent::setUp();

        $this->withFactories(__DIR__ . '/../../../../database/factories');

        $this->addDefaults();
    }


    protected function addDefaults()
    {
        $this->user = create_test_superadmin();

        $this->readPermission   = create_test_permission_with_name('message_groups.read');
        $this->writePermission  = create_test_permission_with_name('message_groups.write');
        $this->deletePermission = create_test_permission_with_name('message_groups.delete');

        $this->actingAs($this->user);
    }


    /** @test */
    public function can_see_grid_without_message_group()
    {
        $this->visit('/backend/message_groups')
             ->see(trans('partymeister-core::backend/message_groups.message_groups'))
             ->see(trans('motor-backend::backend/global.no_records'));
    }


    /** @test */
    public function can_see_grid_with_one_message_group()
    {
        $record = create_test_message_group();
        $this->visit('/backend/message_groups')
             ->see(trans('partymeister-core::backend/message_groups.message_groups'))
             ->see($record->name);
    }


    /** @test */
    public function can_visit_the_edit_form_of_a_message_group_and_use_the_back_button()
    {
        $record = create_test_message_group();
        $this->visit('/backend/message_groups')
             ->within('table', function () {
                 $this->click(trans('motor-backend::backend/global.edit'));
             })
             ->seePageIs('/backend/message_groups/' . $record->id . '/edit')
             ->click(trans('motor-backend::backend/global.back'))
             ->seePageIs('/backend/message_groups');
    }


    /** @test */
    public function can_visit_the_edit_form_of_a_message_group_and_change_values()
    {
        $record = create_test_message_group();

        $this->visit('/backend/message_groups/' . $record->id . '/edit')
             ->see($record->name)
             ->type('Updated Message group', 'name')
             ->within('.box-footer', function () {
                 $this->press(trans('partymeister-core::backend/message_groups.save'));
             })
             ->see(trans('partymeister-core::backend/message_groups.updated'))
             ->see('Updated Message group')
             ->seePageIs('/backend/message_groups');

        $record = MessageGroup::find($record->id);
        $this->assertEquals('Updated Message group', $record->name);
    }


    /** @test */
    public function can_click_the_message_group_create_button()
    {
        $this->visit('/backend/message_groups')
             ->click(trans('partymeister-core::backend/message_groups.new'))
             ->seePageIs('/backend/message_groups/create');
    }


    /** @test */
    public function can_create_a_new_message_group()
    {
        $this->visit('/backend/message_groups/create')
             ->see(trans('partymeister-core::backend/message_groups.new'))
             ->type('Create Message group Name', 'name')
             ->within('.box-footer', function () {
                 $this->press(trans('partymeister-core::backend/message_groups.save'));
             })
             ->see(trans('partymeister-core::backend/message_groups.created'))
             ->see('Create Message group Name')
             ->seePageIs('/backend/message_groups');
    }


    /** @test */
    public function cannot_create_a_new_message_group_with_empty_fields()
    {
        $this->visit('/backend/message_groups/create')
             ->see(trans('partymeister-core::backend/message_groups.new'))
             ->within('.box-footer', function () {
                 $this->press(trans('partymeister-core::backend/message_groups.save'));
             })
             ->see('Data missing!')
             ->seePageIs('/backend/message_groups/create');
    }


    /** @test */
    public function can_modify_a_message_group()
    {
        $record = create_test_message_group();
        $this->visit('/backend/message_groups/' . $record->id . '/edit')
             ->see(trans('partymeister-core::backend/message_groups.edit'))
             ->type('Modified Message group Name', 'name')
             ->within('.box-footer', function () {
                 $this->press(trans('partymeister-core::backend/message_groups.save'));
             })
             ->see(trans('partymeister-core::backend/message_groups.updated'))
             ->see('Modified Message group Name')
             ->seePageIs('/backend/message_groups');
    }


    /** @test */
    public function can_delete_a_message_group()
    {
        create_test_message_group();

        $this->assertCount(1, MessageGroup::all());

        $this->visit('/backend/message_groups')->within('table', function () {
            $this->press(trans('motor-backend::backend/global.delete'));
        })->seePageIs('/backend/message_groups')->see(trans('partymeister-core::backend/message_groups.deleted'));

        $this->assertCount(0, MessageGroup::all());
    }


    /** @test */
    public function can_paginate_message_group_results()
    {
        $records = create_test_message_group(100);
        $this->visit('/backend/message_groups')->within('.pagination', function () {
            $this->click('3');
        })->seePageIs('/backend/message_groups?page=3');
    }


    /** @test */
    public function can_search_message_group_results()
    {
        $records = create_test_message_group(10);
        $this->visit('/backend/message_groups')
             ->type(substr($records[6]->name, 0, 3), 'search')
             ->press('grid-search-button')
             ->seeInField('search', substr($records[6]->name, 0, 3))
             ->see($records[6]->name);
    }
}
