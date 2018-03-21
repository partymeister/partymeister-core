<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Partymeister\Core\Models\ScheduleItem;

class PartymeisterCoreBackendScheduleItemTest extends TestCase
{

    use DatabaseTransactions;

    protected $user;

    protected $readPermission;

    protected $writePermission;

    protected $deletePermission;

    protected $tables = [
        'schedule_items',
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

        $this->withFactories(__DIR__.'/../../../../database/factories');

        $this->addDefaults();
    }


    protected function addDefaults()
    {
        $this->user   = create_test_superadmin();

        $this->readPermission   = create_test_permission_with_name('schedule_items.read');
        $this->writePermission  = create_test_permission_with_name('schedule_items.write');
        $this->deletePermission = create_test_permission_with_name('schedule_items.delete');

        $this->actingAs($this->user);
    }


    /** @test */
    public function can_see_grid_without_schedule_item()
    {
        $this->visit('/backend/schedule_items')
            ->see(trans('partymeister-core::backend/schedule_items.schedule_items'))
            ->see(trans('motor-backend::backend/global.no_records'));
    }

    /** @test */
    public function can_see_grid_with_one_schedule_item()
    {
        $record = create_test_schedule_item();
        $this->visit('/backend/schedule_items')
            ->see(trans('partymeister-core::backend/schedule_items.schedule_items'))
            ->see($record->name);
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_schedule_item_and_use_the_back_button()
    {
        $record = create_test_schedule_item();
        $this->visit('/backend/schedule_items')
            ->within('table', function(){
                $this->click(trans('motor-backend::backend/global.edit'));
            })
            ->seePageIs('/backend/schedule_items/'.$record->id.'/edit')
            ->click(trans('motor-backend::backend/global.back'))
            ->seePageIs('/backend/schedule_items');
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_schedule_item_and_change_values()
    {
        $record = create_test_schedule_item();

        $this->visit('/backend/schedule_items/'.$record->id.'/edit')
            ->see($record->name)
            ->type('Updated Schedule item', 'name')
            ->within('.box-footer', function(){
                $this->press(trans('partymeister-core::backend/schedule_items.save'));
            })
            ->see(trans('partymeister-core::backend/schedule_items.updated'))
            ->see('Updated Schedule item')
            ->seePageIs('/backend/schedule_items');

        $record = ScheduleItem::find($record->id);
        $this->assertEquals('Updated Schedule item', $record->name);
    }

    /** @test */
    public function can_click_the_schedule_item_create_button()
    {
        $this->visit('/backend/schedule_items')
            ->click(trans('partymeister-core::backend/schedule_items.new'))
            ->seePageIs('/backend/schedule_items/create');
    }

    /** @test */
    public function can_create_a_new_schedule_item()
    {
        $this->visit('/backend/schedule_items/create')
            ->see(trans('partymeister-core::backend/schedule_items.new'))
            ->type('Create Schedule item Name', 'name')
            ->within('.box-footer', function(){
                $this->press(trans('partymeister-core::backend/schedule_items.save'));
            })
            ->see(trans('partymeister-core::backend/schedule_items.created'))
            ->see('Create Schedule item Name')
            ->seePageIs('/backend/schedule_items');
    }

    /** @test */
    public function cannot_create_a_new_schedule_item_with_empty_fields()
    {
        $this->visit('/backend/schedule_items/create')
            ->see(trans('partymeister-core::backend/schedule_items.new'))
            ->within('.box-footer', function(){
                $this->press(trans('partymeister-core::backend/schedule_items.save'));
            })
            ->see('Data missing!')
            ->seePageIs('/backend/schedule_items/create');
    }

    /** @test */
    public function can_modify_a_schedule_item()
    {
        $record = create_test_schedule_item();
        $this->visit('/backend/schedule_items/'.$record->id.'/edit')
            ->see(trans('partymeister-core::backend/schedule_items.edit'))
            ->type('Modified Schedule item Name', 'name')
            ->within('.box-footer', function(){
                $this->press(trans('partymeister-core::backend/schedule_items.save'));
            })
            ->see(trans('partymeister-core::backend/schedule_items.updated'))
            ->see('Modified Schedule item Name')
            ->seePageIs('/backend/schedule_items');
    }

    /** @test */
    public function can_delete_a_schedule_item()
    {
        create_test_schedule_item();

        $this->assertCount(1, ScheduleItem::all());

        $this->visit('/backend/schedule_items')
            ->within('table', function(){
                $this->press(trans('motor-backend::backend/global.delete'));
            })
            ->seePageIs('/backend/schedule_items')
            ->see(trans('partymeister-core::backend/schedule_items.deleted'));

        $this->assertCount(0, ScheduleItem::all());
    }

    /** @test */
    public function can_paginate_schedule_item_results()
    {
        $records = create_test_schedule_item(100);
        $this->visit('/backend/schedule_items')
            ->within('.pagination', function(){
                $this->click('3');
            })
            ->seePageIs('/backend/schedule_items?page=3');
    }

    /** @test */
    public function can_search_schedule_item_results()
    {
        $records = create_test_schedule_item(10);
        $this->visit('/backend/schedule_items')
            ->type(substr($records[6]->name, 0, 3), 'search')
            ->press('grid-search-button')
            ->seeInField('search', substr($records[6]->name, 0, 3))
            ->see($records[6]->name);
    }
}
