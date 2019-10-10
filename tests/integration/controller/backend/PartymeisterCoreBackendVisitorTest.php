<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Partymeister\Core\Models\Visitor;

class PartymeisterCoreBackendVisitorTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    protected $readPermission;

    protected $writePermission;

    protected $deletePermission;

    protected $tables = [
        'visitors',
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

        $this->readPermission   = create_test_permission_with_name('visitors.read');
        $this->writePermission  = create_test_permission_with_name('visitors.write');
        $this->deletePermission = create_test_permission_with_name('visitors.delete');

        $this->actingAs($this->user);
    }


    /** @test */
    public function can_see_grid_without_visitor()
    {
        $this->visit('/backend/visitors')
             ->see(trans('partymeister-core::backend/visitors.visitors'))
             ->see(trans('motor-backend::backend/global.no_records'));
    }


    /** @test */
    public function can_see_grid_with_one_visitor()
    {
        $record = create_test_visitor();
        $this->visit('/backend/visitors')
             ->see(trans('partymeister-core::backend/visitors.visitors'))
             ->see($record->name);
    }


    /** @test */
    public function can_visit_the_edit_form_of_a_visitor_and_use_the_back_button()
    {
        $record = create_test_visitor();
        $this->visit('/backend/visitors')
             ->within('table', function () {
                 $this->click(trans('motor-backend::backend/global.edit'));
             })
             ->seePageIs('/backend/visitors/' . $record->id . '/edit')
             ->click(trans('motor-backend::backend/global.back'))
             ->seePageIs('/backend/visitors');
    }


    /** @test */
    public function can_visit_the_edit_form_of_a_visitor_and_change_values()
    {
        $record = create_test_visitor();

        $this->visit('/backend/visitors/' . $record->id . '/edit')
             ->see($record->name)
             ->type('Updated Visitor', 'name')
             ->within('.box-footer', function () {
                 $this->press(trans('partymeister-core::backend/visitors.save'));
             })
             ->see(trans('partymeister-core::backend/visitors.updated'))
             ->see('Updated Visitor')
             ->seePageIs('/backend/visitors');

        $record = Visitor::find($record->id);
        $this->assertEquals('Updated Visitor', $record->name);
    }


    /** @test */
    public function can_click_the_visitor_create_button()
    {
        $this->visit('/backend/visitors')
             ->click(trans('partymeister-core::backend/visitors.new'))
             ->seePageIs('/backend/visitors/create');
    }


    /** @test */
    public function can_create_a_new_visitor()
    {
        $this->visit('/backend/visitors/create')
             ->see(trans('partymeister-core::backend/visitors.new'))
             ->type('Create Visitor Name', 'name')
             ->within('.box-footer', function () {
                 $this->press(trans('partymeister-core::backend/visitors.save'));
             })
             ->see(trans('partymeister-core::backend/visitors.created'))
             ->see('Create Visitor Name')
             ->seePageIs('/backend/visitors');
    }


    /** @test */
    public function cannot_create_a_new_visitor_with_empty_fields()
    {
        $this->visit('/backend/visitors/create')
             ->see(trans('partymeister-core::backend/visitors.new'))
             ->within('.box-footer', function () {
                 $this->press(trans('partymeister-core::backend/visitors.save'));
             })
             ->see('Data missing!')
             ->seePageIs('/backend/visitors/create');
    }


    /** @test */
    public function can_modify_a_visitor()
    {
        $record = create_test_visitor();
        $this->visit('/backend/visitors/' . $record->id . '/edit')
             ->see(trans('partymeister-core::backend/visitors.edit'))
             ->type('Modified Visitor Name', 'name')
             ->within('.box-footer', function () {
                 $this->press(trans('partymeister-core::backend/visitors.save'));
             })
             ->see(trans('partymeister-core::backend/visitors.updated'))
             ->see('Modified Visitor Name')
             ->seePageIs('/backend/visitors');
    }


    /** @test */
    public function can_delete_a_visitor()
    {
        create_test_visitor();

        $this->assertCount(1, Visitor::all());

        $this->visit('/backend/visitors')->within('table', function () {
            $this->press(trans('motor-backend::backend/global.delete'));
        })->seePageIs('/backend/visitors')->see(trans('partymeister-core::backend/visitors.deleted'));

        $this->assertCount(0, Visitor::all());
    }


    /** @test */
    public function can_paginate_visitor_results()
    {
        $records = create_test_visitor(100);
        $this->visit('/backend/visitors')->within('.pagination', function () {
            $this->click('3');
        })->seePageIs('/backend/visitors?page=3');
    }


    /** @test */
    public function can_search_visitor_results()
    {
        $records = create_test_visitor(10);
        $this->visit('/backend/visitors')
             ->type(substr($records[6]->name, 0, 3), 'search')
             ->press('grid-search-button')
             ->seeInField('search', substr($records[6]->name, 0, 3))
             ->see($records[6]->name);
    }
}
