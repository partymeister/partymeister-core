<?php

use Illuminate\Support\Facades\Schema;
use Partymeister\Core\Models\Visitor;

pest()->group('V2', 'V2Auth', 'Register');

describe('V2 Auth Register', function () {

    it('returns 503 when registration is disabled', function () {
        config(['partymeister-core.visitor_registration_enabled' => false]);

        $response = $this->postJson('/api/v2/auth/register', [
            'name' => 'newvisitor',
            'password' => 'secret123',
            'access_key' => 'SOME-KEY',
        ]);

        $response->assertStatus(503)
            ->assertJsonPath('meta.api_version', 'v2')
            ->assertJsonPath('error.code', 'service_unavailable');
    });

    it('returns 409 when name is already taken', function () {
        config(['partymeister-core.visitor_registration_enabled' => true]);

        Visitor::create([
            'name' => 'existingvisitor',
            'password' => bcrypt('secret123'),
            'api_token' => 'test-token',
            'group' => '',
            'country_iso_3166_1' => '',
            'additional_data' => '{}',
        ]);

        // Only run the full test if access_keys table exists
        if (! Schema::hasTable('access_keys')) {
            $this->markTestSkipped('access_keys table not available');
        }

        $response = $this->postJson('/api/v2/auth/register', [
            'name' => 'existingvisitor',
            'password' => 'secret123',
            'access_key' => 'SOME-KEY',
        ]);

        $response->assertStatus(409)
            ->assertJsonPath('meta.api_version', 'v2')
            ->assertJsonPath('error.code', 'conflict');
    });

    it('returns 422 when required fields are missing', function () {
        config(['partymeister-core.visitor_registration_enabled' => true]);

        $response = $this->postJson('/api/v2/auth/register', []);

        $response->assertStatus(422);
    });

    it('registers successfully with valid access key', function () {
        config(['partymeister-core.visitor_registration_enabled' => true]);

        if (! Schema::hasTable('access_keys')) {
            $this->markTestSkipped('access_keys table not available');
        }

        // Create an unassigned access key
        \Partymeister\Competitions\Models\AccessKey::create([
            'access_key' => 'VALID-KEY-123',
            'visitor_id' => null,
            'ip_address' => '',
        ]);

        $response = $this->postJson('/api/v2/auth/register', [
            'name' => 'newvisitor',
            'password' => 'secret123',
            'access_key' => 'VALID-KEY-123',
            'group' => 'MyGroup',
            'country_iso_3166_1' => 'DE',
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('meta.api_version', 'v2')
            ->assertJsonPath('meta.message', 'Registration successful')
            ->assertJsonStructure([
                'data' => [
                    'visitor' => ['id', 'name', 'group', 'country_iso_3166_1'],
                    'token',
                ],
                'meta' => ['api_version', 'message'],
            ])
            ->assertJsonPath('data.visitor.name', 'newvisitor');

        expect(Visitor::where('name', 'newvisitor')->exists())->toBeTrue();
    });
});
