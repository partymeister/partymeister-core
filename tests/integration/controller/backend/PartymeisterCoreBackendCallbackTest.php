<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Partymeister\Core\Models\Callback;

class PartymeisterCoreBackendCallbackTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    protected $readPermission;

    protected $writePermission;

    protected $deletePermission;

    protected $tables = [
        'callbacks',
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

        $this->readPermission   = create_test_permission_with_name('callbacks.read');
        $this->writePermission  = create_test_permission_with_name('callbacks.write');
        $this->deletePermission = create_test_permission_with_name('callbacks.delete');

        $this->actingAs($this->user);
    }


    /** @test */
    public function can_see_grid_without_callback()
    {
        $this->visit('/backend/callbacks')
             ->see(trans('partymeister-core::backend/callbacks.callbacks'))
             ->see(trans('motor-backend::backend/global.no_records'));
    }


    /** @test */
    public function can_see_grid_with_one_callback()
    {
        $record = create_test_callback();
        $this->visit('/backend/callbacks')
             ->see(trans('partymeister-core::backend/callbacks.callbacks'))
             ->see($record->name);
    }


    /** @test */
    public function can_visit_the_edit_form_of_a_callback_and_use_the_back_button()
    {
        $record = create_test_callback();
        $this->visit('/backend/callbacks')
             ->within('table', function () {
                 $this->click(trans('motor-backend::backend/global.edit'));
             })
             ->seePageIs('/backend/callbacks/' . $record->id . '/edit')
             ->click(trans('motor-backend::backend/global.back'))
             ->seePageIs('/backend/callbacks');
    }


    /** @test */
    public function can_visit_the_edit_form_of_a_callback_and_change_values()
    {
        $record = create_test_callback();

        $this->visit('/backend/callbacks/' . $record->id . '/edit')
             ->see($record->name)
             ->type('Updated Callback', 'name')
             ->within('.box-footer', function () {
                 $this->press(trans('partymeister-core::backend/callbacks.save'));
             })
             ->see(trans('partymeister-core::backend/callbacks.updated'))
             ->see('Updated Callback')
             ->seePageIs('/backend/callbacks');

        $record = Callback::find($record->id);
        $this->assertEquals('Updated Callback', $record->name);
    }


    /** @test */
    public function can_click_the_callback_create_button()
    {
        $this->visit('/backend/callbacks')
             ->click(trans('partymeister-core::backend/callbacks.new'))
             ->seePageIs('/backend/callbacks/create');
    }


    /** @test */
    public function can_create_a_new_callback()
    {
        $this->visit('/backend/callbacks/create')
             ->see(trans('partymeister-core::backend/callbacks.new'))
             ->type('Create Callback Name', 'name')
             ->within('.box-footer', function () {
                 $this->press(trans('partymeister-core::backend/callbacks.save'));
             })
             ->see(trans('partymeister-core::backend/callbacks.created'))
             ->see('Create Callback Name')
             ->seePageIs('/backend/callbacks');
    }


    /** @test */
    public function cannot_create_a_new_callback_with_empty_fields()
    {
        $this->visit('/backend/callbacks/create')
             ->see(trans('partymeister-core::backend/callbacks.new'))
             ->within('.box-footer', function () {
                 $this->press(trans('partymeister-core::backend/callbacks.save'));
             })
             ->see('Data missing!')
             ->seePageIs('/backend/callbacks/create');
    }


    /** @test */
    public function can_modify_a_callback()
    {
        $record = create_test_callback();
        $this->visit('/backend/callbacks/' . $record->id . '/edit')
             ->see(trans('partymeister-core::backend/callbacks.edit'))
             ->type('Modified Callback Name', 'name')
             ->within('.box-footer', function () {
                 $this->press(trans('partymeister-core::backend/callbacks.save'));
             })
             ->see(trans('partymeister-core::backend/callbacks.updated'))
             ->see('Modified Callback Name')
             ->seePageIs('/backend/callbacks');
    }


    /** @test */
    public function can_delete_a_callback()
    {
        create_test_callback();

        $this->assertCount(1, Callback::all());

        $this->visit('/backend/callbacks')->within('table', function () {
            $this->press(trans('motor-backend::backend/global.delete'));
        })->seePageIs('/backend/callbacks')->see(trans('partymeister-core::backend/callbacks.deleted'));

        $this->assertCount(0, Callback::all());
    }


    /** @test */
    public function can_paginate_callback_results()
    {
        $records = create_test_callback(100);
        $this->visit('/backend/callbacks')->within('.pagination', function () {
            $this->click('3');
        })->seePageIs('/backend/callbacks?page=3');
    }


    /** @test */
    public function can_search_callback_results()
    {
        $records = create_test_callback(10);
        $this->visit('/backend/callbacks')
             ->type(substr($records[6]->name, 0, 3), 'search')
             ->press('grid-search-button')
             ->seeInField('search', substr($records[6]->name, 0, 3))
             ->see($records[6]->name);
    }
}
