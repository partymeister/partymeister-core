<?php

use Motor\Admin\Models\User;
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

describe('V2 RPC Callback Send Test', function () {

    it('returns 200 when sending a test notification', function () {
        $response = $this->asAdmin()->postJson('/api/v2/rpc/callbacks/send-test');

        $response->assertStatus(200)
            ->assertJsonPath('meta.api_version', 'v2')
            ->assertJsonStructure([
                'data' => ['stuhl_response'],
                'meta' => ['api_version', 'message'],
            ]);
    });
});
