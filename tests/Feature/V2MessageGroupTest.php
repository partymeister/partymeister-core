<?php

use Motor\Admin\Models\User;
use Partymeister\Core\Models\MessageGroup;
use Spatie\Permission\Models\Role;

pest()->group('V2', 'MessageGroup');

beforeEach(function () {
    $role = Role::create(['name' => 'SuperAdmin', 'guard_name' => 'web']);
    $user = User::factory()->create([
        'email' => 'admin@motor-cms.com',
        'name' => 'Admin',
    ]);
    $user->assignRole($role);

    MessageGroup::factory()->create(['name' => 'Group Alpha']);
    MessageGroup::factory()->create(['name' => 'Group Beta']);
    MessageGroup::factory()->create(['name' => 'Group Gamma']);
});

describe('V2 MessageGroups API', function () {

    it('requires authentication', function () {
        assertV2RequiresAuth('/api/v2/message-groups');
    });

    it('includes api_version v2 in response meta', function () {
        $response = $this->asAdmin()->getJson('/api/v2/message-groups');

        $response->assertStatus(200)
            ->assertJsonPath('meta.api_version', 'v2');
    });

    it('can get all message groups', function () {
        assertV2CrudIndex('/api/v2/message-groups', 3, ['id', 'name', 'uuid']);
    });

    it('can get a specific message group', function () {
        assertV2CrudShow(
            '/api/v2/message-groups/'.MessageGroup::first()->id,
            ['id', 'name', 'uuid']
        );
    });

    it('can create a message group', function () {
        $response = assertV2CrudCreate('/api/v2/message-groups', [
            'name' => 'New Group',
        ], MessageGroup::class);

        // Verify uuid is auto-generated
        $response->assertJsonPath('data.uuid', fn ($uuid) => ! is_null($uuid) && strlen($uuid) > 0);
    });

    it('validates required fields on create', function () {
        $countBefore = MessageGroup::count();
        $this->asAdmin()
            ->withHeaders(['Accept' => 'application/json'])
            ->post('/api/v2/message-groups', [])
            ->assertStatus(422);
        expect(MessageGroup::count() - $countBefore)->toBe(0);
    });

    it('can update a message group', function () {
        assertV2CrudUpdate(
            '/api/v2/message-groups/'.MessageGroup::first()->id,
            ['name' => 'Updated Group'],
            'name',
            'Updated Group'
        );
    });

    it('can delete a message group with 204 No Content', function () {
        assertV2CrudDelete(
            '/api/v2/message-groups/'.MessageGroup::latest('id')->first()->id,
            MessageGroup::class
        );
    });
});
