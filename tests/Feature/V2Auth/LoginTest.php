<?php

use Partymeister\Core\Models\Visitor;

pest()->group('V2', 'V2Auth', 'Login');

beforeEach(function () {
    Visitor::factory()->create([
        'name' => 'testvisitor',
        'password' => bcrypt('secret123'),
        'group' => 'TestGroup',
        'country_iso_3166_1' => 'DE',
        'api_token' => 'test-token-123',
        'additional_data' => '{}',
    ]);
});

describe('V2 Auth Login', function () {

    it('returns token and visitor data on successful login', function () {
        config(['partymeister-core.visitor_login_enabled' => true]);

        $response = $this->postJson('/api/v2/auth/login', [
            'name' => 'testvisitor',
            'password' => 'secret123',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('meta.api_version', 'v2')
            ->assertJsonPath('meta.message', 'Login successful')
            ->assertJsonStructure([
                'data' => [
                    'visitor' => ['id', 'name', 'group', 'country_iso_3166_1'],
                    'token',
                ],
                'meta' => ['api_version', 'message'],
            ])
            ->assertJsonPath('data.visitor.name', 'testvisitor');
    });

    it('returns 401 on wrong password', function () {
        config(['partymeister-core.visitor_login_enabled' => true]);

        $response = $this->postJson('/api/v2/auth/login', [
            'name' => 'testvisitor',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJsonPath('meta.api_version', 'v2')
            ->assertJsonPath('error.code', 'invalid_credentials');
    });

    it('returns 503 when login is disabled', function () {
        config(['partymeister-core.visitor_login_enabled' => false]);

        $response = $this->postJson('/api/v2/auth/login', [
            'name' => 'testvisitor',
            'password' => 'secret123',
        ]);

        $response->assertStatus(503)
            ->assertJsonPath('meta.api_version', 'v2')
            ->assertJsonPath('error.code', 'service_unavailable');
    });

    it('returns 422 when name or password is missing', function () {
        config(['partymeister-core.visitor_login_enabled' => true]);

        $response = $this->postJson('/api/v2/auth/login', []);

        $response->assertStatus(422);
    });
});
