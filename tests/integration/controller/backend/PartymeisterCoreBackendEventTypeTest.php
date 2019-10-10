<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Partymeister\Core\Models\EventType;

class PartymeisterCoreBackendEventTypeTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    protected $readPermission;

    protected $writePermission;

    protected $deletePermission;

    protected $tables = [
        'event_types',
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

        $this->readPermission   = create_test_permission_with_name('event_types.read');
        $this->writePermission  = create_test_permission_with_name('event_types.write');
        $this->deletePermission = create_test_permission_with_name('event_types.delete');

        $this->actingAs($this->user);
    }


    /** @test */
    public function can_see_grid_without_event_type()
    {
        $this->visit('/backend/event_types')
             ->see(trans('partymeister-core::backend/event_types.event_types'))
             ->see(trans('motor-backend::backend/global.no_records'));
    }


    /** @test */
    public function can_see_grid_with_one_event_type()
    {
        $record = create_test_event_type();
        $this->visit('/backend/event_types')
             ->see(trans('partymeister-core::backend/event_types.event_types'))
             ->see($record->name);
    }


    /** @test */
    public function can_visit_the_edit_form_of_a_event_type_and_use_the_back_button()
    {
        $record = create_test_event_type();
        $this->visit('/backend/event_types')
             ->within('table', function () {
                 $this->click(trans('motor-backend::backend/global.edit'));
             })
             ->seePageIs('/backend/event_types/' . $record->id . '/edit')
             ->click(trans('motor-backend::backend/global.back'))
             ->seePageIs('/backend/event_types');
    }


    /** @test */
    public function can_visit_the_edit_form_of_a_event_type_and_change_values()
    {
        $record = create_test_event_type();

        $this->visit('/backend/event_types/' . $record->id . '/edit')
             ->see($record->name)
             ->type('Updated Event type', 'name')
             ->within('.box-footer', function () {
                 $this->press(trans('partymeister-core::backend/event_types.save'));
             })
             ->see(trans('partymeister-core::backend/event_types.updated'))
             ->see('Updated Event type')
             ->seePageIs('/backend/event_types');

        $record = EventType::find($record->id);
        $this->assertEquals('Updated Event type', $record->name);
    }


    /** @test */
    public function can_click_the_event_type_create_button()
    {
        $this->visit('/backend/event_types')
             ->click(trans('partymeister-core::backend/event_types.new'))
             ->seePageIs('/backend/event_types/create');
    }


    /** @test */
    public function can_create_a_new_event_type()
    {
        $this->visit('/backend/event_types/create')
             ->see(trans('partymeister-core::backend/event_types.new'))
             ->type('Create Event type Name', 'name')
             ->within('.box-footer', function () {
                 $this->press(trans('partymeister-core::backend/event_types.save'));
             })
             ->see(trans('partymeister-core::backend/event_types.created'))
             ->see('Create Event type Name')
             ->seePageIs('/backend/event_types');
    }


    /** @test */
    public function cannot_create_a_new_event_type_with_empty_fields()
    {
        $this->visit('/backend/event_types/create')
             ->see(trans('partymeister-core::backend/event_types.new'))
             ->within('.box-footer', function () {
                 $this->press(trans('partymeister-core::backend/event_types.save'));
             })
             ->see('Data missing!')
             ->seePageIs('/backend/event_types/create');
    }


    /** @test */
    public function can_modify_a_event_type()
    {
        $record = create_test_event_type();
        $this->visit('/backend/event_types/' . $record->id . '/edit')
             ->see(trans('partymeister-core::backend/event_types.edit'))
             ->type('Modified Event type Name', 'name')
             ->within('.box-footer', function () {
                 $this->press(trans('partymeister-core::backend/event_types.save'));
             })
             ->see(trans('partymeister-core::backend/event_types.updated'))
             ->see('Modified Event type Name')
             ->seePageIs('/backend/event_types');
    }


    /** @test */
    public function can_delete_a_event_type()
    {
        create_test_event_type();

        $this->assertCount(1, EventType::all());

        $this->visit('/backend/event_types')->within('table', function () {
            $this->press(trans('motor-backend::backend/global.delete'));
        })->seePageIs('/backend/event_types')->see(trans('partymeister-core::backend/event_types.deleted'));

        $this->assertCount(0, EventType::all());
    }


    /** @test */
    public function can_paginate_event_type_results()
    {
        $records = create_test_event_type(100);
        $this->visit('/backend/event_types')->within('.pagination', function () {
            $this->click('3');
        })->seePageIs('/backend/event_types?page=3');
    }


    /** @test */
    public function can_search_event_type_results()
    {
        $records = create_test_event_type(10);
        $this->visit('/backend/event_types')
             ->type(substr($records[6]->name, 0, 3), 'search')
             ->press('grid-search-button')
             ->seeInField('search', substr($records[6]->name, 0, 3))
             ->see($records[6]->name);
    }
}
