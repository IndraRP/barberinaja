<?php

namespace App\Livewire\Auth\Resetpassword;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Resetpassword extends Component
{
    use LivewireAlert;

    public $token;
    public $email;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'password' => 'required|min:8|confirmed',
        'password_confirmation' => 'required',
    ];

    protected $messages = [
        'password.required' => 'Kata sandi wajib diisi.',
        'password.min' => 'Kata sandi harus memiliki minimal 8 karakter.',
        'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        'password_confirmation.required' => 'Konfirmasi kata sandi wajib diisi.',
    ];

    public function mount($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function resetPassword()
    {
        try {
            $this->validate();
        } catch (ValidationException $e) {
            $this->alert('error', 'Validasi Gagal!', [
                'text' => collect($e->validator->errors()->all())->implode("\n")
            ]);
            return;
        }

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
            $this->alert('success', 'Berhasil!', [
                'text' => 'Password berhasil direset.'
            ]);
            return redirect()->to('/login');
        } else {
            $this->alert('error', 'Gagal!', [
                'text' => 'Password gagal direset.'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.auth.resetpassword.resetpassword')
            ->extends('layouts.app')
            ->section('content');
    }
}
