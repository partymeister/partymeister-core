<?php

use Motor\Admin\Models\Category;
use Motor\Admin\Models\User;
use Partymeister\Core\Models\Event;
use Partymeister\Core\Models\EventType;
use Partymeister\Core\Models\Schedule;
use Spatie\Permission\Models\Role;

pest()->group('V2', 'V2Rpc', 'SchedulePlaylist');

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
        'starts_at' => '2026-03-23 14:00:00',
        'sort_position' => 1,
    ]);

    Event::factory()->create([
        'name' => 'Music Compo',
        'schedule_id' => $schedule->id,
        'event_type_id' => $eventType->id,
        'starts_at' => '2026-03-23 16:00:00',
        'sort_position' => 2,
    ]);

    // Create root category node for slides scope (needed by ScheduleService::generateSlides)
    $root = new Category;
    $root->scope = 'slides';
    $root->name = 'Slides';
    $root->saveAsRoot();
});

describe('V2 RPC Schedule Playlist API', function () {

    it('GET returns schedule data and days structure', function () {
        $schedule = Schedule::first();

        $response = $this->asAdmin()->getJson('/api/v2/rpc/schedules/'.$schedule->id.'/playlist');

        $response->assertOk()
            ->assertJsonPath('meta.api_version', 'v2')
            ->assertJsonPath('meta.message', 'Schedule playlist data retrieved')
            ->assertJsonStructure([
                'data' => [
                    'schedule' => ['id', 'name'],
                    'template',
                    'days',
                ],
                'meta' => ['api_version', 'message'],
            ])
            ->assertJsonPath('data.schedule.id', $schedule->id)
            ->assertJsonPath('data.schedule.name', 'Main Schedule');
    });

    it('POST returns status ok', function () {
        $schedule = Schedule::first();

        $response = $this->asAdmin()->postJson('/api/v2/rpc/schedules/'.$schedule->id.'/playlist', [
            'slides' => [
                [
                    'key' => 'slide_1',
                    'name' => 'Test Slide',
                    'definitions' => '{}',
                ],
            ],
        ]);

        $response->assertOk()
            ->assertJsonPath('meta.api_version', 'v2')
            ->assertJsonPath('data.status', 'ok');
    });
});
