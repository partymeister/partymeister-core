<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Partymeister\Core\Models\EventItem;

class PartymeisterCoreBackendEventItemTest extends TestCase
{

    use DatabaseTransactions;

    protected $user;

    protected $readPermission;

    protected $writePermission;

    protected $deletePermission;

    protected $tables = [
        'event_items',
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

        $this->readPermission   = create_test_permission_with_name('event_items.read');
        $this->writePermission  = create_test_permission_with_name('event_items.write');
        $this->deletePermission = create_test_permission_with_name('event_items.delete');

        $this->actingAs($this->user);
    }


    /** @test */
    public function can_see_grid_without_event_item()
    {
        $this->visit('/backend/event_items')
            ->see(trans('partymeister-core::backend/event_items.event_items'))
            ->see(trans('motor-backend::backend/global.no_records'));
    }

    /** @test */
    public function can_see_grid_with_one_event_item()
    {
        $record = create_test_event_item();
        $this->visit('/backend/event_items')
            ->see(trans('partymeister-core::backend/event_items.event_items'))
            ->see($record->name);
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_event_item_and_use_the_back_button()
    {
        $record = create_test_event_item();
        $this->visit('/backend/event_items')
            ->within('table', function(){
                $this->click(trans('motor-backend::backend/global.edit'));
            })
            ->seePageIs('/backend/event_items/'.$record->id.'/edit')
            ->click(trans('motor-backend::backend/global.back'))
            ->seePageIs('/backend/event_items');
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_event_item_and_change_values()
    {
        $record = create_test_event_item();

        $this->visit('/backend/event_items/'.$record->id.'/edit')
            ->see($record->name)
            ->type('Updated Event item', 'name')
            ->within('.box-footer', function(){
                $this->press(trans('partymeister-core::backend/event_items.save'));
            })
            ->see(trans('partymeister-core::backend/event_items.updated'))
            ->see('Updated Event item')
            ->seePageIs('/backend/event_items');

        $record = EventItem::find($record->id);
        $this->assertEquals('Updated Event item', $record->name);
    }

    /** @test */
    public function can_click_the_event_item_create_button()
    {
        $this->visit('/backend/event_items')
            ->click(trans('partymeister-core::backend/event_items.new'))
            ->seePageIs('/backend/event_items/create');
    }

    /** @test */
    public function can_create_a_new_event_item()
    {
        $this->visit('/backend/event_items/create')
            ->see(trans('partymeister-core::backend/event_items.new'))
            ->type('Create Event item Name', 'name')
            ->within('.box-footer', function(){
                $this->press(trans('partymeister-core::backend/event_items.save'));
            })
            ->see(trans('partymeister-core::backend/event_items.created'))
            ->see('Create Event item Name')
            ->seePageIs('/backend/event_items');
    }

    /** @test */
    public function cannot_create_a_new_event_item_with_empty_fields()
    {
        $this->visit('/backend/event_items/create')
            ->see(trans('partymeister-core::backend/event_items.new'))
            ->within('.box-footer', function(){
                $this->press(trans('partymeister-core::backend/event_items.save'));
            })
            ->see('Data missing!')
            ->seePageIs('/backend/event_items/create');
    }

    /** @test */
    public function can_modify_a_event_item()
    {
        $record = create_test_event_item();
        $this->visit('/backend/event_items/'.$record->id.'/edit')
            ->see(trans('partymeister-core::backend/event_items.edit'))
            ->type('Modified Event item Name', 'name')
            ->within('.box-footer', function(){
                $this->press(trans('partymeister-core::backend/event_items.save'));
            })
            ->see(trans('partymeister-core::backend/event_items.updated'))
            ->see('Modified Event item Name')
            ->seePageIs('/backend/event_items');
    }

    /** @test */
    public function can_delete_a_event_item()
    {
        create_test_event_item();

        $this->assertCount(1, EventItem::all());

        $this->visit('/backend/event_items')
            ->within('table', function(){
                $this->press(trans('motor-backend::backend/global.delete'));
            })
            ->seePageIs('/backend/event_items')
            ->see(trans('partymeister-core::backend/event_items.deleted'));

        $this->assertCount(0, EventItem::all());
    }

    /** @test */
    public function can_paginate_event_item_results()
    {
        $records = create_test_event_item(100);
        $this->visit('/backend/event_items')
            ->within('.pagination', function(){
                $this->click('3');
            })
            ->seePageIs('/backend/event_items?page=3');
    }

    /** @test */
    public function can_search_event_item_results()
    {
        $records = create_test_event_item(10);
        $this->visit('/backend/event_items')
            ->type(substr($records[6]->name, 0, 3), 'search')
            ->press('grid-search-button')
            ->seeInField('search', substr($records[6]->name, 0, 3))
            ->see($records[6]->name);
    }
}
