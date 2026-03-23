<?php

use Motor\Admin\Models\User;
use Partymeister\Core\Models\Guest;
use Spatie\Permission\Models\Role;

pest()->group('V2', 'RPC', 'Guest');

beforeEach(function () {
    $role = Role::create(['name' => 'SuperAdmin', 'guard_name' => 'web']);
    $user = User::factory()->create([
        'email' => 'admin@motor-cms.com',
        'name' => 'Admin',
    ]);
    $user->assignRole($role);

    // Authenticate so BlameableTrait can set created_by/updated_by
    auth()->login($user);

    Guest::create([
        'name' => 'Scannable Guest',
        'handle' => 'scannable',
        'email' => 'scan@example.com',
        'company' => 'ScanCo',
        'country' => 'DE',
        'ticket_code' => 'SCAN001',
        'ticket_type' => 'VIP',
        'ticket_order_number' => 'ORD001',
        'has_badge' => false,
        'has_arrived' => false,
        'ticket_code_scanned' => false,
        'comment' => '',
    ]);

    Guest::create([
        'name' => 'Already Scanned',
        'handle' => 'scanned',
        'email' => 'scanned@example.com',
        'company' => 'ScannedCo',
        'country' => 'US',
        'ticket_code' => 'SCAN002',
        'ticket_type' => 'Regular',
        'ticket_order_number' => 'ORD002',
        'has_badge' => false,
        'has_arrived' => true,
        'ticket_code_scanned' => true,
        'arrived_at' => '2026-01-01 12:00:00',
        'comment' => '',
    ]);

    Guest::create([
        'name' => 'Already Arrived',
        'handle' => 'arrived',
        'email' => 'arrived@example.com',
        'company' => 'ArrivedCo',
        'country' => 'GB',
        'ticket_code' => 'SCAN003',
        'ticket_type' => 'Regular',
        'ticket_order_number' => 'ORD003',
        'has_badge' => false,
        'has_arrived' => true,
        'ticket_code_scanned' => false,
        'arrived_at' => '2026-01-01 10:00:00',
        'comment' => '',
    ]);
});

describe('V2 RPC Guest Scan Ticket', function () {

    it('successfully scans a ticket', function () {
        $response = $this->asAdmin()->postJson('/api/v2/rpc/guests/scan-ticket', [
            'ticket_code' => 'SCAN001',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('meta.api_version', 'v2')
            ->assertJsonPath('data.ticket_code', 'SCAN001')
            ->assertJsonPath('data.has_arrived', true)
            ->assertJsonPath('data.ticket_code_scanned', true);

        $guest = Guest::where('ticket_code', 'SCAN001')->first();
        expect($guest->has_arrived)->toBeTruthy();
        expect($guest->ticket_code_scanned)->toBeTruthy();
        expect($guest->arrived_at)->not->toBeNull();
    });

    it('returns 404 when ticket code is not found', function () {
        $response = $this->asAdmin()->postJson('/api/v2/rpc/guests/scan-ticket', [
            'ticket_code' => 'NONEXISTENT',
        ]);

        $response->assertStatus(404)
            ->assertJsonPath('meta.api_version', 'v2')
            ->assertJsonPath('data', null);
    });

    it('returns 409 when ticket has already been scanned', function () {
        $response = $this->asAdmin()->postJson('/api/v2/rpc/guests/scan-ticket', [
            'ticket_code' => 'SCAN002',
        ]);

        $response->assertStatus(409)
            ->assertJsonPath('meta.api_version', 'v2');
    });

    it('returns 409 when guest has already arrived', function () {
        $response = $this->asAdmin()->postJson('/api/v2/rpc/guests/scan-ticket', [
            'ticket_code' => 'SCAN003',
        ]);

        $response->assertStatus(409)
            ->assertJsonPath('meta.api_version', 'v2');
    });
});
