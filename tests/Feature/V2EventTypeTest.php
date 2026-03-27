<?php

use Motor\Admin\Models\User;
use Partymeister\Core\Models\EventType;
use Spatie\Permission\Models\Role;

pest()->group('V2', 'EventType');

beforeEach(function () {
    $role = Role::create(['name' => 'SuperAdmin', 'guard_name' => 'web']);
    $user = User::factory()->create([
        'email' => 'admin@motor-cms.com',
        'name' => 'Admin',
    ]);
    $user->assignRole($role);

    EventType::factory()->create(['name' => 'Competition', 'web_color' => '#63a848', 'slide_color' => '#3c692c']);
    EventType::factory()->create(['name' => 'Deadline', 'web_color' => '#e5554a', 'slide_color' => '#e5554a']);
    EventType::factory()->create(['name' => 'Event', 'web_color' => '#fad028', 'slide_color' => '#fad028']);
});

describe('V2 EventTypes API', function () {

    it('requires authentication', function () {
        assertV2RequiresAuth('/api/v2/event-types');
    });

    it('includes api_version v2 in response meta', function () {
        $response = $this->asAdmin()->getJson('/api/v2/event-types');

        $response->assertStatus(200)
            ->assertJsonPath('meta.api_version', 'v2');
    });

    it('can get all event types', function () {
        assertV2CrudIndex('/api/v2/event-types', 3, ['id', 'name', 'web_color', 'slide_color']);
    });

    it('can get a specific event type', function () {
        assertV2CrudShow(
            '/api/v2/event-types/'.EventType::first()->id,
            ['id', 'name', 'web_color', 'slide_color']
        );
    });

    it('can create an event type', function () {
        assertV2CrudCreate('/api/v2/event-types', [
            'name' => 'Test Type',
            'web_color' => '#ff0000',
            'slide_color' => '#00ff00',
        ], EventType::class);
    });

    it('validates required fields on create', function () {
        $countBefore = EventType::count();
        $this->asAdmin()
            ->withHeaders(['Accept' => 'application/json'])
            ->post('/api/v2/event-types', [])
            ->assertStatus(422);
        expect(EventType::count() - $countBefore)->toBe(0);
    });

    it('can update an event type', function () {
        assertV2CrudUpdate(
            '/api/v2/event-types/'.EventType::first()->id,
            ['name' => 'Updated Name'],
            'name',
            'Updated Name'
        );
    });

    it('can delete an event type with 204 No Content', function () {
        assertV2CrudDelete(
            '/api/v2/event-types/'.EventType::latest('id')->first()->id,
            EventType::class
        );
    });
});
