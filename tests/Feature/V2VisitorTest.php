<?php

use Motor\Admin\Models\User;
use Partymeister\Core\Models\Visitor;
use Spatie\Permission\Models\Role;

pest()->group('V2', 'Visitor');

beforeEach(function () {
    $role = Role::create(['name' => 'SuperAdmin', 'guard_name' => 'web']);
    $user = User::factory()->create([
        'email' => 'admin@motor-cms.com',
        'name' => 'Admin',
    ]);
    $user->assignRole($role);

    Visitor::factory()->create(['name' => 'Alice', 'group' => 'TeamA', 'country_iso_3166_1' => 'DE', 'password' => bcrypt('secret123'), 'api_token' => 'token1', 'additional_data' => []]);
    Visitor::factory()->create(['name' => 'Bob', 'group' => 'TeamB', 'country_iso_3166_1' => 'US', 'password' => bcrypt('secret456'), 'api_token' => 'token2', 'additional_data' => []]);
    Visitor::factory()->create(['name' => 'Charlie', 'group' => 'TeamC', 'country_iso_3166_1' => 'GB', 'password' => bcrypt('secret789'), 'api_token' => 'token3', 'additional_data' => []]);
});

describe('V2 Visitors API', function () {

    it('requires authentication', function () {
        assertV2RequiresAuth('/api/v2/visitors');
    });

    it('includes api_version v2 in response meta', function () {
        $response = $this->asAdmin()->getJson('/api/v2/visitors');

        $response->assertStatus(200)
            ->assertJsonPath('meta.api_version', 'v2');
    });

    it('can get all visitors', function () {
        assertV2CrudIndex('/api/v2/visitors', 3, ['id', 'name', 'group', 'country_iso_3166_1']);
    });

    it('can get a specific visitor', function () {
        assertV2CrudShow(
            '/api/v2/visitors/'.Visitor::first()->id,
            ['id', 'name', 'group', 'country_iso_3166_1']
        );
    });

    it('does not expose password or api_token', function () {
        $response = $this->asAdmin()->getJson('/api/v2/visitors/'.Visitor::first()->id);

        $response->assertOk()
            ->assertJsonMissing(['password'])
            ->assertJsonMissing(['api_token']);
    });

    it('can create a visitor', function () {
        assertV2CrudCreate('/api/v2/visitors', [
            'name' => 'NewVisitor',
            'password' => 'password123',
            'group' => 'NewGroup',
            'country_iso_3166_1' => 'FR',
        ], Visitor::class);
    });

    it('validates required fields on create', function () {
        $countBefore = Visitor::count();
        $this->asAdmin()
            ->withHeaders(['Accept' => 'application/json'])
            ->post('/api/v2/visitors', [])
            ->assertStatus(422);
        expect(Visitor::count() - $countBefore)->toBe(0);
    });

    it('can update a visitor', function () {
        assertV2CrudUpdate(
            '/api/v2/visitors/'.Visitor::first()->id,
            ['name' => 'Updated Name'],
            'name',
            'Updated Name'
        );
    });

    it('can delete a visitor with 204 No Content', function () {
        assertV2CrudDelete(
            '/api/v2/visitors/'.Visitor::latest('id')->first()->id,
            Visitor::class
        );
    });
});
