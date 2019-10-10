<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Partymeister\Core\Models\Guest;

class PartymeisterCoreBackendGuestTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    protected $readPermission;

    protected $writePermission;

    protected $deletePermission;

    protected $tables = [
        'guests',
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

        $this->readPermission   = create_test_permission_with_name('guests.read');
        $this->writePermission  = create_test_permission_with_name('guests.write');
        $this->deletePermission = create_test_permission_with_name('guests.delete');

        $this->actingAs($this->user);
    }


    /** @test */
    public function can_see_grid_without_guest()
    {
        $this->visit('/backend/guests')
             ->see(trans('partymeister-core::backend/guests.guests'))
             ->see(trans('motor-backend::backend/global.no_records'));
    }


    /** @test */
    public function can_see_grid_with_one_guest()
    {
        $record = create_test_guest();
        $this->visit('/backend/guests')->see(trans('partymeister-core::backend/guests.guests'))->see($record->name);
    }


    /** @test */
    public function can_visit_the_edit_form_of_a_guest_and_use_the_back_button()
    {
        $record = create_test_guest();
        $this->visit('/backend/guests')
             ->within('table', function () {
                 $this->click(trans('motor-backend::backend/global.edit'));
             })
             ->seePageIs('/backend/guests/' . $record->id . '/edit')
             ->click(trans('motor-backend::backend/global.back'))
             ->seePageIs('/backend/guests');
    }


    /** @test */
    public function can_visit_the_edit_form_of_a_guest_and_change_values()
    {
        $record = create_test_guest();

        $this->visit('/backend/guests/' . $record->id . '/edit')
             ->see($record->name)
             ->type('Updated Guest', 'name')
             ->within('.box-footer', function () {
                 $this->press(trans('partymeister-core::backend/guests.save'));
             })
             ->see(trans('partymeister-core::backend/guests.updated'))
             ->see('Updated Guest')
             ->seePageIs('/backend/guests');

        $record = Guest::find($record->id);
        $this->assertEquals('Updated Guest', $record->name);
    }


    /** @test */
    public function can_click_the_guest_create_button()
    {
        $this->visit('/backend/guests')
             ->click(trans('partymeister-core::backend/guests.new'))
             ->seePageIs('/backend/guests/create');
    }


    /** @test */
    public function can_create_a_new_guest()
    {
        $this->visit('/backend/guests/create')
             ->see(trans('partymeister-core::backend/guests.new'))
             ->type('Create Guest Name', 'name')
             ->within('.box-footer', function () {
                 $this->press(trans('partymeister-core::backend/guests.save'));
             })
             ->see(trans('partymeister-core::backend/guests.created'))
             ->see('Create Guest Name')
             ->seePageIs('/backend/guests');
    }


    /** @test */
    public function cannot_create_a_new_guest_with_empty_fields()
    {
        $this->visit('/backend/guests/create')
             ->see(trans('partymeister-core::backend/guests.new'))
             ->within('.box-footer', function () {
                 $this->press(trans('partymeister-core::backend/guests.save'));
             })
             ->see('Data missing!')
             ->seePageIs('/backend/guests/create');
    }


    /** @test */
    public function can_modify_a_guest()
    {
        $record = create_test_guest();
        $this->visit('/backend/guests/' . $record->id . '/edit')
             ->see(trans('partymeister-core::backend/guests.edit'))
             ->type('Modified Guest Name', 'name')
             ->within('.box-footer', function () {
                 $this->press(trans('partymeister-core::backend/guests.save'));
             })
             ->see(trans('partymeister-core::backend/guests.updated'))
             ->see('Modified Guest Name')
             ->seePageIs('/backend/guests');
    }


    /** @test */
    public function can_delete_a_guest()
    {
        create_test_guest();

        $this->assertCount(1, Guest::all());

        $this->visit('/backend/guests')->within('table', function () {
            $this->press(trans('motor-backend::backend/global.delete'));
        })->seePageIs('/backend/guests')->see(trans('partymeister-core::backend/guests.deleted'));

        $this->assertCount(0, Guest::all());
    }


    /** @test */
    public function can_paginate_guest_results()
    {
        $records = create_test_guest(100);
        $this->visit('/backend/guests')->within('.pagination', function () {
            $this->click('3');
        })->seePageIs('/backend/guests?page=3');
    }


    /** @test */
    public function can_search_guest_results()
    {
        $records = create_test_guest(10);
        $this->visit('/backend/guests')
             ->type(substr($records[6]->name, 0, 3), 'search')
             ->press('grid-search-button')
             ->seeInField('search', substr($records[6]->name, 0, 3))
             ->see($records[6]->name);
    }
}
