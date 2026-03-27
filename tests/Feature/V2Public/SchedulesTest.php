<?php

use Partymeister\Core\Models\Schedule;

pest()->group('V2', 'V2Public', 'Schedule');

beforeEach(function () {
    Schedule::factory()->create(['name' => 'Friday Schedule']);
    Schedule::factory()->create(['name' => 'Saturday Schedule']);
    Schedule::factory()->create(['name' => 'Sunday Schedule']);
});

describe('V2 Public Schedules API', function () {

    it('can list schedules without authentication', function () {
        $response = $this->getJson('/api/v2/public/schedules');

        $response->assertOk();
        assertV2ResponseEnvelope($response);
        $response->assertJsonCount(3, 'data');
        $response->assertJsonStructure(['data' => ['*' => ['id', 'name']]]);
    });

    it('can show a single schedule without authentication', function () {
        $schedule = Schedule::first();

        $response = $this->getJson('/api/v2/public/schedules/'.$schedule->id);

        $response->assertOk();
        assertV2ResponseEnvelope($response);
        $response->assertJsonStructure(['data' => ['id', 'name']]);
        $response->assertJsonPath('data.id', $schedule->id);
    });

    it('includes message in meta', function () {
        $response = $this->getJson('/api/v2/public/schedules');

        $response->assertOk();
        $response->assertJsonPath('meta.message', 'Schedules retrieved');
    });
});
