<?php

use Motor\Admin\Models\User;
use Partymeister\Core\Models\Callback;
use Spatie\Permission\Models\Role;

pest()->group('V2', 'RPC', 'Callback');

beforeEach(function () {
    $role = Role::create(['name' => 'SuperAdmin', 'guard_name' => 'web']);
    $user = User::factory()->create([
        'email' => 'admin@motor-cms.com',
        'name' => 'Admin',
    ]);
    $user->assignRole($role);
});

describe('V2 RPC Callback Fire', function () {

    it('fires a notification callback successfully', function () {
        $callback = Callback::create([
            'name' => 'Test Fire',
            'action' => 'notification',
            'payload' => '{}',
            'title' => 'Test Title',
            'body' => 'Test Body',
            'link' => '',
            'destination' => 'orga',
            'hash' => 'firehash1',
            'is_timed' => false,
            'has_fired' => false,
        ]);

        $response = $this->asAdmin()->postJson('/api/v2/rpc/callbacks/'.$callback->id.'/fire');

        $response->assertStatus(200)
            ->assertJsonPath('meta.api_version', 'v2')
            ->assertJsonPath('data.status', 'fired')
            ->assertJsonPath('data.action', 'notification');

        $callback->refresh();
        expect($callback->has_fired)->toBeTruthy();
    });

    it('returns already_fired status for a fired callback', function () {
        $callback = Callback::create([
            'name' => 'Already Fired',
            'action' => 'notification',
            'payload' => '{}',
            'title' => 'Title',
            'body' => 'Body',
            'link' => '',
            'destination' => 'orga',
            'hash' => 'firedhash',
            'is_timed' => false,
            'has_fired' => true,
            'fired_at' => '2026-01-01 12:00:00',
        ]);

        $response = $this->asAdmin()->postJson('/api/v2/rpc/callbacks/'.$callback->id.'/fire');

        $response->assertStatus(200)
            ->assertJsonPath('meta.api_version', 'v2')
            ->assertJsonPath('data.status', 'already_fired');

        $firedAt = $response->json('data.fired_at');
        expect($firedAt)->toStartWith('2026-01-01T12:00:00');
    });

    it('returns 403 when embargo time has not been reached', function () {
        $callback = Callback::create([
            'name' => 'Embargo Test',
            'action' => 'notification',
            'payload' => '{}',
            'title' => 'Title',
            'body' => 'Body',
            'link' => '',
            'destination' => 'orga',
            'hash' => 'embargohash',
            'is_timed' => true,
            'has_fired' => false,
            'embargo_until' => date('Y-m-d H:i:s', strtotime('+1 day')),
        ]);

        $response = $this->asAdmin()->postJson('/api/v2/rpc/callbacks/'.$callback->id.'/fire');

        $response->assertStatus(403)
            ->assertJsonPath('meta.api_version', 'v2');
    });
});
