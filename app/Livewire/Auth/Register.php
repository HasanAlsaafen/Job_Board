<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Register extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $role = 'seeker';
    public $successMessage = '';

    protected $rules = [
        'name'                  => 'required|string|max:255',
        'email'                 => 'required|string|email|max:255|unique:users',
        'password'              => 'required|string|min:8|confirmed',
        'password_confirmation' => 'required',
        'role'                  => 'required|in:seeker,employer',
    ];
    public function registerUser()
    {
        $this->validate();
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->role,
        ]);

        auth()->login($user);

        $this->successMessage = 'Registration successful! Redirecting to dashboard...';
        if ($user->role == 'employer') {
            return redirect()->to('dashboard');
        } else {
            return redirect()->to('/');
        }
    }
    public function render()
    {
        return view('livewire.auth.register')->layout('layouts.guest');
    }
}
