<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('displays the login and register pages for guests', function () {
    $this->get(route('login'))->assertOk();
    $this->get(route('register'))->assertOk();
});

it('registers a new user with the normal_user role', function () {
    $response = $this->post(route('register'), [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect(route('home'));
    $this->assertAuthenticated();

    $user = User::query()->where('email', 'jane@example.com')->first();

    expect($user)->not->toBeNull()
        ->and($user->role)->toBe('normal_user');
});

it('logs in website users and redirects them to the home page', function () {
    $user = User::factory()->create([
        'email' => 'member@example.com',
        'password' => 'password123',
        'role' => 'normal_user',
    ]);

    $response = $this->post(route('login'), [
        'email' => 'member@example.com',
        'password' => 'password123',
    ]);

    $response->assertRedirect(route('home'));
    $this->assertAuthenticatedAs($user);
});

it('allows admins and managers to log in through the main website', function (string $role) {
    $user = User::factory()->create([
        'email' => "{$role}@example.com",
        'password' => 'password123',
        'role' => $role,
    ]);

    $response = $this->post(route('login'), [
        'email' => "{$role}@example.com",
        'password' => 'password123',
    ]);

    $response->assertRedirect(route('home'));
    $this->assertAuthenticatedAs($user);
})->with(['admin', 'manager']);

it('blocks normal users from accessing the admin panel', function () {
    $user = User::factory()->create(['role' => 'normal_user']);

    $this->actingAs($user)
        ->get(route('admin.dashboard'))
        ->assertForbidden();
});

it('redirects authenticated users away from login and register pages', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('login'))
        ->assertRedirect(route('home'));

    $this->actingAs($user)
        ->get(route('register'))
        ->assertRedirect(route('home'));
});

it('logs users out and redirects them to the home page', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('logout'));

    $response->assertRedirect(route('home'));
    $this->assertGuest();
});
