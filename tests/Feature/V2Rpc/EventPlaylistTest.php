<?php

use Motor\Admin\Models\User;
use Partymeister\Core\Models\Event;
use Partymeister\Core\Models\EventType;
use Partymeister\Core\Models\Schedule;
use Spatie\Permission\Models\Role;

pest()->group('V2', 'V2Rpc', 'EventPlaylist');

beforeEach(function () {
    $role = Role::create(['name' => 'SuperAdmin', 'guard_name' => 'web']);
    $user = User::factory()->create([
        'email' => 'admin@motor-cms.com',
        'name' => 'Admin',
    ]);
    $user->assignRole($role);

    $eventType = EventType::create(['name' => 'Competition', 'web_color' => '#63a848', 'slide_color' => '#3c692c']);
    $schedule = Schedule::create(['name' => 'Main Schedule']);

    Event::create([
        'name' => 'Opening Ceremony',
        'schedule_id' => $schedule->id,
        'event_type_id' => $eventType->id,
        'is_visible' => 1,
        'is_organizer_only' => 0,
        'sort_position' => 1,
        'notify_minutes' => 0,
        'link' => '',
    ]);
});

describe('V2 RPC Event Playlist API', function () {

    it('GET returns event data and templates structure', function () {
        $event = Event::first();

        $response = $this->asAdmin()->getJson('/api/v2/rpc/events/'.$event->id.'/playlist');

        $response->assertOk()
            ->assertJsonPath('meta.api_version', 'v2')
            ->assertJsonPath('meta.message', 'Event playlist data retrieved')
            ->assertJsonStructure([
                'data' => [
                    'event' => ['id', 'name'],
                    'templates',
                ],
                'meta' => ['api_version', 'message'],
            ])
            ->assertJsonPath('data.event.id', $event->id)
            ->assertJsonPath('data.event.name', 'Opening Ceremony');
    });

    it('POST returns status ok', function () {
        $event = Event::first();

        $mock = Mockery::mock('alias:Partymeister\Slides\Services\PlaylistService');
        $mock->shouldReceive('generateEventPlaylist')
            ->once()
            ->andReturnNull();

        $response = $this->asAdmin()->postJson('/api/v2/rpc/events/'.$event->id.'/playlist', [
            'slides' => [],
        ]);

        $response->assertOk()
            ->assertJsonPath('meta.api_version', 'v2')
            ->assertJsonPath('data.status', 'ok');
    });
});
