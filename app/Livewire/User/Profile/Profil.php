<?php

namespace App\Livewire\User\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Profil extends Component
{
    use WithFileUploads;
    use LivewireAlert;

    public $user;
    public $name;
    public $email;
    public $phone_number;
    public $password;
    public $new_password;
    public $confirm_password;
    public $image;
    public $imageUpload;

    protected $listeners = ['logout'];
    public $isImageValid = false;

    public function mount()
    {
        // Pastikan user sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->user = Auth::user();
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->phone_number = $this->user->phone_number;
        $this->image = $this->user->image;
    }


    public function updateProfile()
    {
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore(Auth::id())],
            'phone_number' => 'nullable|string|max:255',
            'password' => 'nullable|current_password',
            'new_password' => 'nullable|string|min:8|same:confirm_password',
        ]);

        // Perbarui data pengguna
        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
        ]);

        // Tambahkan flash message
        $this->alert('success', 'Berhasil!', [
            'text' => 'Profile Berhasil di Perbarui.'
        ]);
        return redirect()->route('profile');
    }

    public function updatedImageUpload()
    {
        $this->resetValidation();
        $this->isImageValid = false;

        try {
            $this->validate([
                'imageUpload' => 'nullable|image|mimes:jpeg,png,jpg,JPG,gif,webp|max:2024',
            ]);

            $this->isImageValid = true;
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->addError('imageUpload', 'File yang diunggah lebih dari 2MB.');
        }
    }

    public function saveimage()
    {
        $validatedData = $this->validate([
            'imageUpload' => 'nullable|image|mimes:jpeg,png,jpg,JPG,gif,webp|max:2024',
        ]);

        if ($this->imageUpload) {
            if ($this->user->image) {
                Storage::disk('public')->delete($this->user->image);
            }

            $this->image = $this->imageUpload->store('images/profiles', 'public');
        }

        $this->user->update([
            'image' => $this->image,
        ]);

        $this->alert('success', 'Perubahan berhasil dilakukan.');
        return redirect()->route('profile');
    }


    public function updatePassword()
    {
        $this->validate([
            'password' => 'required|current_password',
            'new_password' => 'required|string|min:8|same:confirm_password',
        ]);

        $this->user->update([
            'password' => Hash::make($this->new_password),
        ]);

        session()->flash('message', 'Password berhasil diperbarui!');
        return redirect()->route('profile')->with('message', 'Profil berhasil diperbarui!');
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.user.profile.profil')
            ->extends('layouts.app')
            ->section('content');
    }
}
