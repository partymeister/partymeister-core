<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Partymeister\Core\Models\Schedule;

class PartymeisterCoreBackendScheduleTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    protected $readPermission;

    protected $writePermission;

    protected $deletePermission;

    protected $tables = [
        'schedules',
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

        $this->readPermission   = create_test_permission_with_name('schedules.read');
        $this->writePermission  = create_test_permission_with_name('schedules.write');
        $this->deletePermission = create_test_permission_with_name('schedules.delete');

        $this->actingAs($this->user);
    }


    /** @test */
    public function can_see_grid_without_schedule()
    {
        $this->visit('/backend/schedules')
             ->see(trans('partymeister-core::backend/schedules.schedules'))
             ->see(trans('motor-backend::backend/global.no_records'));
    }


    /** @test */
    public function can_see_grid_with_one_schedule()
    {
        $record = create_test_schedule();
        $this->visit('/backend/schedules')
             ->see(trans('partymeister-core::backend/schedules.schedules'))
             ->see($record->name);
    }


    /** @test */
    public function can_visit_the_edit_form_of_a_schedule_and_use_the_back_button()
    {
        $record = create_test_schedule();
        $this->visit('/backend/schedules')
             ->within('table', function () {
                 $this->click(trans('motor-backend::backend/global.edit'));
             })
             ->seePageIs('/backend/schedules/' . $record->id . '/edit')
             ->click(trans('motor-backend::backend/global.back'))
             ->seePageIs('/backend/schedules');
    }


    /** @test */
    public function can_visit_the_edit_form_of_a_schedule_and_change_values()
    {
        $record = create_test_schedule();

        $this->visit('/backend/schedules/' . $record->id . '/edit')
             ->see($record->name)
             ->type('Updated Schedule', 'name')
             ->within('.box-footer', function () {
                 $this->press(trans('partymeister-core::backend/schedules.save'));
             })
             ->see(trans('partymeister-core::backend/schedules.updated'))
             ->see('Updated Schedule')
             ->seePageIs('/backend/schedules');

        $record = Schedule::find($record->id);
        $this->assertEquals('Updated Schedule', $record->name);
    }


    /** @test */
    public function can_click_the_schedule_create_button()
    {
        $this->visit('/backend/schedules')
             ->click(trans('partymeister-core::backend/schedules.new'))
             ->seePageIs('/backend/schedules/create');
    }


    /** @test */
    public function can_create_a_new_schedule()
    {
        $this->visit('/backend/schedules/create')
             ->see(trans('partymeister-core::backend/schedules.new'))
             ->type('Create Schedule Name', 'name')
             ->within('.box-footer', function () {
                 $this->press(trans('partymeister-core::backend/schedules.save'));
             })
             ->see(trans('partymeister-core::backend/schedules.created'))
             ->see('Create Schedule Name')
             ->seePageIs('/backend/schedules');
    }


    /** @test */
    public function cannot_create_a_new_schedule_with_empty_fields()
    {
        $this->visit('/backend/schedules/create')
             ->see(trans('partymeister-core::backend/schedules.new'))
             ->within('.box-footer', function () {
                 $this->press(trans('partymeister-core::backend/schedules.save'));
             })
             ->see('Data missing!')
             ->seePageIs('/backend/schedules/create');
    }


    /** @test */
    public function can_modify_a_schedule()
    {
        $record = create_test_schedule();
        $this->visit('/backend/schedules/' . $record->id . '/edit')
             ->see(trans('partymeister-core::backend/schedules.edit'))
             ->type('Modified Schedule Name', 'name')
             ->within('.box-footer', function () {
                 $this->press(trans('partymeister-core::backend/schedules.save'));
             })
             ->see(trans('partymeister-core::backend/schedules.updated'))
             ->see('Modified Schedule Name')
             ->seePageIs('/backend/schedules');
    }


    /** @test */
    public function can_delete_a_schedule()
    {
        create_test_schedule();

        $this->assertCount(1, Schedule::all());

        $this->visit('/backend/schedules')->within('table', function () {
            $this->press(trans('motor-backend::backend/global.delete'));
        })->seePageIs('/backend/schedules')->see(trans('partymeister-core::backend/schedules.deleted'));

        $this->assertCount(0, Schedule::all());
    }


    /** @test */
    public function can_paginate_schedule_results()
    {
        $records = create_test_schedule(100);
        $this->visit('/backend/schedules')->within('.pagination', function () {
            $this->click('3');
        })->seePageIs('/backend/schedules?page=3');
    }


    /** @test */
    public function can_search_schedule_results()
    {
        $records = create_test_schedule(10);
        $this->visit('/backend/schedules')
             ->type(substr($records[6]->name, 0, 3), 'search')
             ->press('grid-search-button')
             ->seeInField('search', substr($records[6]->name, 0, 3))
             ->see($records[6]->name);
    }
}
