<?php

use Partymeister\Core\Models\Event;
use Partymeister\Core\Models\EventType;
use Partymeister\Core\Models\Schedule;

pest()->group('V2', 'V2Public', 'Event');

beforeEach(function () {
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
});

describe('V2 Public Events API', function () {

    it('can list events without authentication', function () {
        $response = $this->getJson('/api/v2/public/events');

        $response->assertOk();
        assertV2ResponseEnvelope($response);
        $response->assertJsonCount(2, 'data');
        $response->assertJsonStructure(['data' => ['*' => ['id', 'name', 'is_visible', 'sort_position']]]);
    });

    it('can show a single event without authentication', function () {
        $event = Event::first();

        $response = $this->getJson('/api/v2/public/events/'.$event->id);

        $response->assertOk();
        assertV2ResponseEnvelope($response);
        $response->assertJsonStructure(['data' => ['id', 'name', 'is_visible', 'sort_position']]);
        $response->assertJsonPath('data.id', $event->id);
    });

    it('includes message in meta', function () {
        $response = $this->getJson('/api/v2/public/events');

        $response->assertOk();
        $response->assertJsonPath('meta.message', 'Events retrieved');
    });
});
