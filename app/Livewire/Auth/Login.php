<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class Login extends Component
{
    public $email = '';
    public $password = '';
    public $errorMessage = '';

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function loginUser()
    {
        $this->validate();

        if (auth()->attempt(['email' => $this->email, 'password' => $this->password])) {

            if (auth()->user()->role === 'employer') {
                return redirect()->to('/dashboard');
            }
            return redirect()->to('/');
        }

        $this->errorMessage = 'Invalid credentials. Please try again.';
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.guest');
    }
}
