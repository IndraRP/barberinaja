<?php

namespace App\Livewire\Auth\Forgotpassword;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Password;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Forgotpassword extends Component
{
    use LivewireAlert;
    
    public $email;

    protected $rules = [
        'email' => 'required|email',
    ];

    protected $messages = [
        'email.required' => 'Alamat email tidak boleh kosong.',
        'email.email' => 'Format email tidak valid.',
    ];

    public function sendResetLink()
    {
        $this->validate();
    
        $user = User::where('email', $this->email)->first();
    
        if (!$user) {
            $this->alert('error', 'Gagal!', [
                'text' => 'Alamat email tidak terdaftar dalam sistem kami.'
            ]);
            return;
        }
    
        $this->reset(['email']);
    
        // Menggunakan notifikasi bawaan Laravel
        $user->notify(new ResetPassword(Password::createToken($user)));
    
        $this->alert('success', 'Berhasil!', [
            'text' => 'Link reset password telah dikirim ke email Anda.'
        ]);
    }

    
    public function render()
    {
        return view('livewire.auth.forgotpassword.forgotpassword')
        ->extends('layouts.app')
        ->section('content');
    }
}
