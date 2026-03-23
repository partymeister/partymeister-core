<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Partymeister\Core\Mail\PasswordReset;
use Partymeister\Core\Models\Visitor;

pest()->group('V2', 'V2Auth', 'PasswordReset');

describe('V2 Auth Password Forgot', function () {

    it('returns 200 regardless of whether email exists', function () {
        Mail::fake();

        $response = $this->postJson('/api/v2/auth/password/forgot', [
            'email' => 'nonexistent@example.com',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('meta.api_version', 'v2')
            ->assertJsonPath('meta.message', 'If the email exists, a reset link has been sent');

        Mail::assertNothingSent();
    });

    it('sends a reset email when visitor email exists', function () {
        Mail::fake();

        Visitor::create([
            'name' => 'resetuser',
            'password' => bcrypt('oldpassword'),
            'email' => 'reset@example.com',
            'api_token' => 'token-123',
            'group' => '',
            'country_iso_3166_1' => '',
            'additional_data' => '{}',
        ]);

        $response = $this->postJson('/api/v2/auth/password/forgot', [
            'email' => 'reset@example.com',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('meta.api_version', 'v2');

        Mail::assertSent(PasswordReset::class);
    });

    it('returns 422 when email is missing', function () {
        $response = $this->postJson('/api/v2/auth/password/forgot', []);

        $response->assertStatus(422);
    });
});

describe('V2 Auth Password Reset', function () {

    it('resets password with valid token', function () {
        $visitor = Visitor::create([
            'name' => 'resetuser',
            'password' => bcrypt('oldpassword'),
            'email' => 'reset@example.com',
            'api_token' => 'token-123',
            'group' => '',
            'country_iso_3166_1' => '',
            'additional_data' => '{}',
        ]);

        DB::table('password_resets')->insert([
            'email' => 'reset@example.com',
            'token' => 'valid-reset-token',
            'created_at' => Carbon::now(),
        ]);

        $response = $this->postJson('/api/v2/auth/password/reset', [
            'token' => 'valid-reset-token',
            'password' => 'newpassword123',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('meta.api_version', 'v2')
            ->assertJsonPath('meta.message', 'Password has been reset');

        // Verify password was actually changed
        $visitor->refresh();
        expect(Hash::check('newpassword123', $visitor->password))->toBeTrue();

        // Verify reset tokens were cleaned up
        expect(DB::table('password_resets')->where('email', 'reset@example.com')->count())->toBe(0);
    });

    it('returns 404 for invalid token', function () {
        $response = $this->postJson('/api/v2/auth/password/reset', [
            'token' => 'nonexistent-token',
            'password' => 'newpassword123',
        ]);

        $response->assertStatus(404)
            ->assertJsonPath('meta.api_version', 'v2')
            ->assertJsonPath('error.code', 'not_found');
    });

    it('returns 404 for expired token', function () {
        Visitor::create([
            'name' => 'resetuser',
            'password' => bcrypt('oldpassword'),
            'email' => 'reset@example.com',
            'api_token' => 'token-123',
            'group' => '',
            'country_iso_3166_1' => '',
            'additional_data' => '{}',
        ]);

        DB::table('password_resets')->insert([
            'email' => 'reset@example.com',
            'token' => 'expired-token',
            'created_at' => Carbon::now()->subMinutes(61),
        ]);

        $response = $this->postJson('/api/v2/auth/password/reset', [
            'token' => 'expired-token',
            'password' => 'newpassword123',
        ]);

        $response->assertStatus(404)
            ->assertJsonPath('error.code', 'not_found');
    });

    it('returns 422 when token or password is missing', function () {
        $response = $this->postJson('/api/v2/auth/password/reset', []);

        $response->assertStatus(422);
    });
});
