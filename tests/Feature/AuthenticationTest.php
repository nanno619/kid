<?php

use App\Models\User;

test('the login page renders the existing custom view', function () {
    $response = $this->get('/login');

    $response->assertSuccessful();
    $response->assertViewIs('login');
});

test('a user can log in with correct credentials and is redirected to the dashboard', function () {
    $user = User::factory()->create(['password' => bcrypt('password')]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticatedAs($user);
    $response->assertRedirect('/dashboard');
});

test('a user cannot log in with incorrect credentials', function () {
    $user = User::factory()->create(['password' => bcrypt('password')]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors();
});

test('a logged in user can log out', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->post('/logout');

    $this->assertGuest();
});

test('the dashboard requires authentication', function () {
    $response = $this->get('/dashboard');

    $response->assertRedirect('/login');
});

test('an authenticated user can view the dashboard', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertSuccessful();
});
