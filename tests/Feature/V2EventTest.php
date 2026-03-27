<?php

use Motor\Admin\Models\User;
use Partymeister\Core\Models\Event;
use Partymeister\Core\Models\EventType;
use Partymeister\Core\Models\Schedule;
use Spatie\Permission\Models\Role;

pest()->group('V2', 'Event');

beforeEach(function () {
    $role = Role::create(['name' => 'SuperAdmin', 'guard_name' => 'web']);
    $user = User::factory()->create([
        'email' => 'admin@motor-cms.com',
        'name' => 'Admin',
    ]);
    $user->assignRole($role);

    $eventType = EventType::factory()->create(['name' => 'Competition', 'web_color' => '#63a848', 'slide_color' => '#3c692c']);
    $schedule = Schedule::factory()->create(['name' => 'Main Schedule']);

    Event::factory()->create([
        'name' => 'Opening Ceremony',
        'schedule_id' => $schedule->id,
        'event_type_id' => $eventType->id,
        'sort_position' => 1,
    ]);
    Event::factory()->create([
        'name' => 'Music Compo',
        'schedule_id' => $schedule->id,
        'event_type_id' => $eventType->id,
        'sort_position' => 2,
    ]);
    Event::factory()->create([
        'name' => 'Closing Ceremony',
        'schedule_id' => $schedule->id,
        'event_type_id' => $eventType->id,
        'sort_position' => 3,
    ]);
});

describe('V2 Events API', function () {

    it('requires authentication', function () {
        assertV2RequiresAuth('/api/v2/events');
    });

    it('includes api_version v2 in response meta', function () {
        $response = $this->asAdmin()->getJson('/api/v2/events');

        $response->assertStatus(200)
            ->assertJsonPath('meta.api_version', 'v2');
    });

    it('can get all events', function () {
        assertV2CrudIndex('/api/v2/events', 3, ['id', 'name', 'starts_at', 'ends_at', 'is_visible', 'is_organizer_only', 'sort_position']);
    });

    it('can get a specific event', function () {
        assertV2CrudShow(
            '/api/v2/events/'.Event::first()->id,
            ['id', 'name', 'starts_at', 'ends_at', 'is_visible', 'is_organizer_only', 'sort_position']
        );
    });

    it('can create an event', function () {
        assertV2CrudCreate('/api/v2/events', [
            'name' => 'Test Event',
            'schedule_id' => Schedule::first()->id,
            'event_type_id' => EventType::first()->id,
            'is_visible' => 1,
            'is_organizer_only' => 0,
            'sort_position' => 10,
            'notify_minutes' => 0,
            'link' => '',
        ], Event::class);
    });

    it('validates required fields on create', function () {
        $countBefore = Event::count();
        $this->asAdmin()
            ->withHeaders(['Accept' => 'application/json'])
            ->post('/api/v2/events', [])
            ->assertStatus(422);
        expect(Event::count() - $countBefore)->toBe(0);
    });

    it('can update an event', function () {
        assertV2CrudUpdate(
            '/api/v2/events/'.Event::first()->id,
            ['name' => 'Updated Event Name'],
            'name',
            'Updated Event Name'
        );
    });

    it('can delete an event with 204 No Content', function () {
        assertV2CrudDelete(
            '/api/v2/events/'.Event::latest('id')->first()->id,
            Event::class
        );
    });
});
