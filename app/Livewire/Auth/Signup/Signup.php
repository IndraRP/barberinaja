<?php

namespace App\Livewire\Auth\Signup;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Signup extends Component
{

    public $name, $email, $phone_number, $password, $password_confirmation, $role = 'customer';

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone_number' => 'nullable|string|max:255',
        'password' => 'required|string|min:8|confirmed',
        'password_confirmation' => 'required|same:password', // Pastikan konfirmasi password sama
        'role' => 'required|in:owner,barber,customer',
    ];

    public function register()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'password' => Hash::make($this->password),
            'role' => $this->role,
        ]);

        session()->flash('message', 'Sign up successful! Please login.');
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.auth.signup.signup')
        ->extends('layouts.app')
        ->section('content');
    }
}