<?php

use Motor\Admin\Models\User;
use Partymeister\Core\Models\Schedule;
use Spatie\Permission\Models\Role;

pest()->group('V2', 'Schedule');

beforeEach(function () {
    $role = Role::create(['name' => 'SuperAdmin', 'guard_name' => 'web']);
    $user = User::factory()->create([
        'email' => 'admin@motor-cms.com',
        'name' => 'Admin',
    ]);
    $user->assignRole($role);

    Schedule::factory()->create(['name' => 'Friday Schedule']);
    Schedule::factory()->create(['name' => 'Saturday Schedule']);
    Schedule::factory()->create(['name' => 'Sunday Schedule']);
});

describe('V2 Schedules API', function () {

    it('requires authentication', function () {
        assertV2RequiresAuth('/api/v2/schedules');
    });

    it('includes api_version v2 in response meta', function () {
        $response = $this->asAdmin()->getJson('/api/v2/schedules');

        $response->assertStatus(200)
            ->assertJsonPath('meta.api_version', 'v2');
    });

    it('can get all schedules', function () {
        assertV2CrudIndex('/api/v2/schedules', 3, ['id', 'name']);
    });

    it('can get a specific schedule', function () {
        assertV2CrudShow(
            '/api/v2/schedules/'.Schedule::first()->id,
            ['id', 'name']
        );
    });

    it('can create a schedule', function () {
        assertV2CrudCreate('/api/v2/schedules', [
            'name' => 'Test Schedule',
        ], Schedule::class);
    });

    it('validates required fields on create', function () {
        $countBefore = Schedule::count();
        $this->asAdmin()
            ->withHeaders(['Accept' => 'application/json'])
            ->post('/api/v2/schedules', [])
            ->assertStatus(422);
        expect(Schedule::count() - $countBefore)->toBe(0);
    });

    it('can update a schedule', function () {
        assertV2CrudUpdate(
            '/api/v2/schedules/'.Schedule::first()->id,
            ['name' => 'Updated Schedule Name'],
            'name',
            'Updated Schedule Name'
        );
    });

    it('can delete a schedule with 204 No Content', function () {
        assertV2CrudDelete(
            '/api/v2/schedules/'.Schedule::latest('id')->first()->id,
            Schedule::class
        );
    });
});
