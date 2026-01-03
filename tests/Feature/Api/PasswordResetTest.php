<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

uses(RefreshDatabase::class);

test('user can request a password reset link', function () {
    User::factory()->create(['email' => 'test@example.com']);

    $response = $this->postJson('/api/forgot-password', [
        'email' => 'test@example.com',
    ]);

    $response->assertStatus(200)
        ->assertJson(['message' => __('passwords.sent')]);
});

test('user can reset password with a valid token', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('old-password'),
    ]);

    $token = Password::createToken($user);

    $response = $this->postJson('/api/reset-password', [
        'token' => $token,
        'email' => 'test@example.com',
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ]);

    $response->assertStatus(200)
        ->assertJson(['message' => __('passwords.reset')]);

    expect(Hash::check('new-password', $user->refresh()->password))->toBeTrue();
});

test('password reset fails with invalid token', function () {
    User::factory()->create(['email' => 'test@example.com']);

    $response = $this->postJson('/api/reset-password', [
        'token' => 'invalid-token',
        'email' => 'test@example.com',
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ]);

    $response->assertStatus(400)
        ->assertJson(['message' => __('passwords.token')]);
});
