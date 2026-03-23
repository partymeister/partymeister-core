<?php

use Motor\Admin\Models\User;
use Partymeister\Core\Models\Guest;
use Spatie\Permission\Models\Role;

pest()->group('V2', 'Guest');

beforeEach(function () {
    $role = Role::create(['name' => 'SuperAdmin', 'guard_name' => 'web']);
    $user = User::factory()->create([
        'email' => 'admin@motor-cms.com',
        'name' => 'Admin',
    ]);
    $user->assignRole($role);

    // Authenticate so BlameableTrait can set created_by/updated_by
    auth()->login($user);

    Guest::create(['name' => 'Guest One', 'handle' => 'guest1', 'email' => 'guest1@example.com', 'company' => 'CompanyA', 'country' => 'DE', 'ticket_code' => 'TC001', 'ticket_type' => 'VIP', 'ticket_order_number' => 'ORD001', 'has_badge' => false, 'has_arrived' => false, 'ticket_code_scanned' => false, 'comment' => '']);
    Guest::create(['name' => 'Guest Two', 'handle' => 'guest2', 'email' => 'guest2@example.com', 'company' => 'CompanyB', 'country' => 'US', 'ticket_code' => 'TC002', 'ticket_type' => 'Regular', 'ticket_order_number' => 'ORD002', 'has_badge' => false, 'has_arrived' => false, 'ticket_code_scanned' => false, 'comment' => '']);
    Guest::create(['name' => 'Guest Three', 'handle' => 'guest3', 'email' => 'guest3@example.com', 'company' => 'CompanyC', 'country' => 'GB', 'ticket_code' => 'TC003', 'ticket_type' => 'Regular', 'ticket_order_number' => 'ORD003', 'has_badge' => false, 'has_arrived' => true, 'ticket_code_scanned' => false, 'comment' => '']);
});

describe('V2 Guests API', function () {

    it('includes api_version v2 in response meta', function () {
        $response = $this->asAdmin()->getJson('/api/v2/guests');

        $response->assertStatus(200)
            ->assertJsonPath('meta.api_version', 'v2');
    });

    it('can get all guests', function () {
        assertV2CrudIndex('/api/v2/guests', 3, ['id', 'name', 'handle', 'email', 'company', 'country']);
    });

    it('can get a specific guest', function () {
        assertV2CrudShow(
            '/api/v2/guests/'.Guest::first()->id,
            ['id', 'name', 'handle', 'email', 'company', 'country']
        );
    });

    it('can create a guest', function () {
        assertV2CrudCreate('/api/v2/guests', [
            'name' => 'New Guest',
            'handle' => 'newguest',
            'email' => 'new@example.com',
            'company' => 'NewCo',
            'country' => 'FR',
            'ticket_code' => 'TC004',
            'ticket_type' => 'Regular',
            'ticket_order_number' => 'ORD004',
            'has_badge' => false,
            'has_arrived' => false,
            'ticket_code_scanned' => false,
            'comment' => 'Test guest',
        ], Guest::class);
    });

    it('validates required fields on create', function () {
        $countBefore = Guest::count();
        $this->asAdmin()
            ->withHeaders(['Accept' => 'application/json'])
            ->post('/api/v2/guests', [])
            ->assertStatus(422);
        expect(Guest::count() - $countBefore)->toBe(0);
    });

    it('can update a guest', function () {
        assertV2CrudUpdate(
            '/api/v2/guests/'.Guest::first()->id,
            ['name' => 'Updated Guest'],
            'name',
            'Updated Guest'
        );
    });

    it('can delete a guest with 204 No Content', function () {
        assertV2CrudDelete(
            '/api/v2/guests/'.Guest::latest('id')->first()->id,
            Guest::class
        );
    });
});
