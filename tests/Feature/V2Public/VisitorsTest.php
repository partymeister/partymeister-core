<?php

use Partymeister\Core\Models\Visitor;

pest()->group('V2', 'V2Public', 'Visitor');

beforeEach(function () {
    Visitor::create(['name' => 'Alice', 'group' => 'TeamA', 'country_iso_3166_1' => 'DE', 'password' => bcrypt('secret123'), 'api_token' => 'token1', 'additional_data' => []]);
    Visitor::create(['name' => 'Bob', 'group' => 'TeamB', 'country_iso_3166_1' => 'US', 'password' => bcrypt('secret456'), 'api_token' => 'token2', 'additional_data' => []]);
    Visitor::create(['name' => 'Charlie', 'group' => 'TeamC', 'country_iso_3166_1' => 'GB', 'password' => bcrypt('secret789'), 'api_token' => 'token3', 'additional_data' => []]);
});

describe('V2 Public Visitors API', function () {

    it('can list visitors without authentication', function () {
        $response = $this->getJson('/api/v2/public/visitors');

        $response->assertOk();
        assertV2ResponseEnvelope($response);
        $response->assertJsonCount(3, 'data');
        $response->assertJsonStructure(['data' => ['*' => ['id', 'name', 'group', 'country_iso_3166_1']]]);
    });

    it('includes message in meta', function () {
        $response = $this->getJson('/api/v2/public/visitors');

        $response->assertOk();
        $response->assertJsonPath('meta.message', 'Visitors retrieved');
    });

    it('does not expose password, api_token, or email', function () {
        $response = $this->getJson('/api/v2/public/visitors');

        $response->assertOk()
            ->assertJsonMissing(['password'])
            ->assertJsonMissing(['api_token'])
            ->assertJsonMissing(['email'])
            ->assertJsonMissing(['additional_data']);
    });
});
