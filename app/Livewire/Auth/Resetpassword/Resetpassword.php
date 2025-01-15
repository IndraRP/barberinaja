<?php

namespace App\Livewire\Auth\Resetpassword;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Livewire\Component;

class Resetpassword extends Component
{
    public $token;
    public $email;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'password' => 'required|min:8|confirmed',
        'password_confirmation' => 'required',
    ];

    public function mount($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function resetPassword()
    {
        $this->validate();

        $status = Password::reset(
            [
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'token' => $this->token,
            ],
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            session()->flash('status', 'Password berhasil direset.');
            return redirect()->to('/login');
        } else {
            session()->flash('error', 'Reset password gagal.');
        }
    }

    public function render()
    {
        return view('livewire.auth.resetpassword.resetpassword')
        ->extends('layouts.app')
        ->section('content');
    }
}
