<?php

namespace App\Livewire\Auth\Login;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class AuthLoginIndex extends Component
{
    use LivewireAlert; // Tambahkan trait ini

    public $email, $password, $remember;

    protected $messages = [
        'required' => 'Harap bagian :attribute diisi.',
        'email' => 'Format email tidak valid.',
        'password.min' => 'Password minimal 8 karakter.',
    ];

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ], $this->messages);
    
        $user = User::where('email', $this->email)->first();
    
        if (!$user || !Hash::check($this->password, $user->password)) {
            // Menggunakan session flash untuk menyimpan pesan kesalahan
            session()->flash('error', 'Email atau password salah!');
            return; // Tidak perlu menampilkan alert
        }
    
        // Login berhasil
        Auth::login($user, $this->remember);
    
        // Redirect berdasarkan role
        return $this->redirectBasedOnRole($user);
    }
    

    private function redirectBasedOnRole($user)
    {
        if ($user->role->value === 'owner') {
            return redirect('/admin');
        } elseif ($user->role->value === 'barber') {
            return redirect()->route('home_barber');
        } elseif ($user->role->value === 'customer') {
            return redirect()->route('home');
        }

        return redirect('/');
    }

    public function render()
    {
        return view('livewire.auth.login.auth-login-index')
            ->extends('layouts.app')
            ->section('content');
    }
}
