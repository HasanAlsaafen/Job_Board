<?php

use App\Livewire\Auth\Register;
use App\Models\User;
use Livewire\Livewire;
use Laravel\Fortify\Features;

beforeEach(function () {
    $this->skipUnlessFortifyHas(Features::registration());
});

test('registration screen can be rendered', function () {
    $response = $this->get(route('register'));

    $response->assertOk();
});

test('new users can register', function () {
    $response = $this->post(route('register.store'), [
        'name' => 'John Doe',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertSessionHasNoErrors()
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
});

test('employer registrations persist the employer role', function () {
    Livewire::test(Register::class)
        ->set('name', 'Employer User')
        ->set('email', 'employer@example.com')
        ->set('password', 'password')
        ->set('role', 'employer')
        ->call('registerUser')
        ->assertRedirect('/dashboard');

    expect(User::where('email', 'employer@example.com')->value('role'))->toBe('employer');
});
