<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Partymeister\Core\Models\Event;

class PartymeisterCoreBackendEventTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    protected $readPermission;

    protected $writePermission;

    protected $deletePermission;

    protected $tables = [
        'events',
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

        $this->readPermission   = create_test_permission_with_name('events.read');
        $this->writePermission  = create_test_permission_with_name('events.write');
        $this->deletePermission = create_test_permission_with_name('events.delete');

        $this->actingAs($this->user);
    }


    /** @test */
    public function can_see_grid_without_event()
    {
        $this->visit('/backend/events')
             ->see(trans('partymeister-core::backend/events.events'))
             ->see(trans('motor-backend::backend/global.no_records'));
    }


    /** @test */
    public function can_see_grid_with_one_event()
    {
        $record = create_test_event();
        $this->visit('/backend/events')->see(trans('partymeister-core::backend/events.events'))->see($record->name);
    }


    /** @test */
    public function can_visit_the_edit_form_of_a_event_and_use_the_back_button()
    {
        $record = create_test_event();
        $this->visit('/backend/events')
             ->within('table', function () {
                 $this->click(trans('motor-backend::backend/global.edit'));
             })
             ->seePageIs('/backend/events/' . $record->id . '/edit')
             ->click(trans('motor-backend::backend/global.back'))
             ->seePageIs('/backend/events');
    }


    /** @test */
    public function can_visit_the_edit_form_of_a_event_and_change_values()
    {
        $record = create_test_event();

        $this->visit('/backend/events/' . $record->id . '/edit')
             ->see($record->name)
             ->type('Updated Event', 'name')
             ->within('.box-footer', function () {
                 $this->press(trans('partymeister-core::backend/events.save'));
             })
             ->see(trans('partymeister-core::backend/events.updated'))
             ->see('Updated Event')
             ->seePageIs('/backend/events');

        $record = Event::find($record->id);
        $this->assertEquals('Updated Event', $record->name);
    }


    /** @test */
    public function can_click_the_event_create_button()
    {
        $this->visit('/backend/events')
             ->click(trans('partymeister-core::backend/events.new'))
             ->seePageIs('/backend/events/create');
    }


    /** @test */
    public function can_create_a_new_event()
    {
        $this->visit('/backend/events/create')
             ->see(trans('partymeister-core::backend/events.new'))
             ->type('Create Event Name', 'name')
             ->within('.box-footer', function () {
                 $this->press(trans('partymeister-core::backend/events.save'));
             })
             ->see(trans('partymeister-core::backend/events.created'))
             ->see('Create Event Name')
             ->seePageIs('/backend/events');
    }


    /** @test */
    public function cannot_create_a_new_event_with_empty_fields()
    {
        $this->visit('/backend/events/create')
             ->see(trans('partymeister-core::backend/events.new'))
             ->within('.box-footer', function () {
                 $this->press(trans('partymeister-core::backend/events.save'));
             })
             ->see('Data missing!')
             ->seePageIs('/backend/events/create');
    }


    /** @test */
    public function can_modify_a_event()
    {
        $record = create_test_event();
        $this->visit('/backend/events/' . $record->id . '/edit')
             ->see(trans('partymeister-core::backend/events.edit'))
             ->type('Modified Event Name', 'name')
             ->within('.box-footer', function () {
                 $this->press(trans('partymeister-core::backend/events.save'));
             })
             ->see(trans('partymeister-core::backend/events.updated'))
             ->see('Modified Event Name')
             ->seePageIs('/backend/events');
    }


    /** @test */
    public function can_delete_a_event()
    {
        create_test_event();

        $this->assertCount(1, Event::all());

        $this->visit('/backend/events')->within('table', function () {
            $this->press(trans('motor-backend::backend/global.delete'));
        })->seePageIs('/backend/events')->see(trans('partymeister-core::backend/events.deleted'));

        $this->assertCount(0, Event::all());
    }


    /** @test */
    public function can_paginate_event_results()
    {
        $records = create_test_event(100);
        $this->visit('/backend/events')->within('.pagination', function () {
            $this->click('3');
        })->seePageIs('/backend/events?page=3');
    }


    /** @test */
    public function can_search_event_results()
    {
        $records = create_test_event(10);
        $this->visit('/backend/events')
             ->type(substr($records[6]->name, 0, 3), 'search')
             ->press('grid-search-button')
             ->seeInField('search', substr($records[6]->name, 0, 3))
             ->see($records[6]->name);
    }
}
