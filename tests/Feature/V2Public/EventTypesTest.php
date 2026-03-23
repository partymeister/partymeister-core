<?php

use Partymeister\Core\Models\EventType;

pest()->group('V2', 'V2Public', 'EventType');

beforeEach(function () {
    EventType::create(['name' => 'Competition', 'web_color' => '#63a848', 'slide_color' => '#3c692c']);
    EventType::create(['name' => 'Deadline', 'web_color' => '#e5554a', 'slide_color' => '#e5554a']);
    EventType::create(['name' => 'Event', 'web_color' => '#fad028', 'slide_color' => '#fad028']);
});

describe('V2 Public EventTypes API', function () {

    it('can list event types without authentication', function () {
        $response = $this->getJson('/api/v2/public/event-types');

        $response->assertOk();
        assertV2ResponseEnvelope($response);
        $response->assertJsonCount(3, 'data');
        $response->assertJsonStructure(['data' => ['*' => ['id', 'name', 'web_color', 'slide_color']]]);
    });

    it('can show a single event type without authentication', function () {
        $eventType = EventType::first();

        $response = $this->getJson('/api/v2/public/event-types/'.$eventType->id);

        $response->assertOk();
        assertV2ResponseEnvelope($response);
        $response->assertJsonStructure(['data' => ['id', 'name', 'web_color', 'slide_color']]);
        $response->assertJsonPath('data.id', $eventType->id);
    });

    it('includes message in meta', function () {
        $response = $this->getJson('/api/v2/public/event-types');

        $response->assertOk();
        $response->assertJsonPath('meta.message', 'Event types retrieved');
    });
});
