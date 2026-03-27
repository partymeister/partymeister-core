<?php

use Motor\Admin\Models\User;
use Partymeister\Core\Models\Callback;
use Spatie\Permission\Models\Role;

pest()->group('V2', 'Callback');

beforeEach(function () {
    $role = Role::create(['name' => 'SuperAdmin', 'guard_name' => 'web']);
    $user = User::factory()->create([
        'email' => 'admin@motor-cms.com',
        'name' => 'Admin',
    ]);
    $user->assignRole($role);

    Callback::factory()->create(['name' => 'Test Callback 1', 'action' => 'notify', 'payload' => '{}', 'title' => 'Title 1', 'body' => 'Body 1', 'link' => '', 'destination' => 'slack', 'hash' => 'hash1', 'is_timed' => false, 'has_fired' => false]);
    Callback::factory()->create(['name' => 'Test Callback 2', 'action' => 'notify', 'payload' => '{}', 'title' => 'Title 2', 'body' => 'Body 2', 'link' => '', 'destination' => 'telegram', 'hash' => 'hash2', 'is_timed' => true, 'has_fired' => false]);
    Callback::factory()->create(['name' => 'Test Callback 3', 'action' => 'notify', 'payload' => '{}', 'title' => 'Title 3', 'body' => 'Body 3', 'link' => '', 'destination' => 'slack', 'hash' => 'hash3', 'is_timed' => false, 'has_fired' => true]);
});

describe('V2 Callbacks API', function () {

    it('requires authentication', function () {
        assertV2RequiresAuth('/api/v2/callbacks');
    });

    it('includes api_version v2 in response meta', function () {
        $response = $this->asAdmin()->getJson('/api/v2/callbacks');

        $response->assertStatus(200)
            ->assertJsonPath('meta.api_version', 'v2');
    });

    it('can get all callbacks', function () {
        assertV2CrudIndex('/api/v2/callbacks', 3, ['id', 'name', 'action', 'payload', 'title', 'body', 'link', 'destination', 'hash']);
    });

    it('can get a specific callback', function () {
        assertV2CrudShow(
            '/api/v2/callbacks/'.Callback::first()->id,
            ['id', 'name', 'action', 'payload', 'title', 'body', 'link', 'destination', 'hash']
        );
    });

    it('can create a callback', function () {
        $response = assertV2CrudCreate('/api/v2/callbacks', [
            'name' => 'New Callback',
            'action' => 'notify',
            'payload' => '{"key":"value"}',
            'title' => 'New Title',
            'body' => 'New Body',
            'link' => 'https://example.com',
            'destination' => 'slack',
        ], Callback::class);

        // Verify hash is auto-generated
        $response->assertJsonPath('data.hash', fn ($hash) => ! is_null($hash) && strlen($hash) > 0);
    });

    it('validates required fields on create', function () {
        $countBefore = Callback::count();
        $this->asAdmin()
            ->withHeaders(['Accept' => 'application/json'])
            ->post('/api/v2/callbacks', [])
            ->assertStatus(422);
        expect(Callback::count() - $countBefore)->toBe(0);
    });

    it('can update a callback', function () {
        assertV2CrudUpdate(
            '/api/v2/callbacks/'.Callback::first()->id,
            ['name' => 'Updated Callback'],
            'name',
            'Updated Callback'
        );
    });

    it('can delete a callback with 204 No Content', function () {
        assertV2CrudDelete(
            '/api/v2/callbacks/'.Callback::latest('id')->first()->id,
            Callback::class
        );
    });
});
