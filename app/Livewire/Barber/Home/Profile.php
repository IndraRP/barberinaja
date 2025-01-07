<?php

namespace App\Livewire\Barber\Home;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public $user;
    public $name;
    public $email;
    public $phone_number;
    public $password;
    public $new_password;
    public $confirm_password;
    public $image; 
    public $imageUpload;

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
            'imageUpload' => 'nullable|image|mimes:jpeg,png,jpg,JPG,gif,webp|max:1024', // Validasi format file
        ]);

        if ($this->imageUpload) {
            // Hapus file gambar lama jika ada
            if ($this->user->image) {
                Storage::disk('public')->delete($this->user->image);
            }

            // Simpan file gambar baru
            $this->image = $this->imageUpload->store('images/profiles', 'public');
        }

        // Perbarui data pengguna
        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'image' => $this->image,
        ]);

        // Tambahkan flash message
        session()->flash('message', 'Profil berhasil diperbarui!');
        return redirect()->route('profile')->with('message', 'Profil berhasil diperbarui!');
    }

    public function updatePassword()
    {
        // Validasi password
        $this->validate([
            'password' => 'required|current_password',
            'new_password' => 'required|string|min:8|same:confirm_password',
        ]);

        // Perbarui password pengguna
        $this->user->update([
            'password' => Hash::make($this->new_password),
        ]);

        // Tambahkan flash message
        session()->flash('message', 'Password berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.barber.home.profile')
        ->extends('layouts.barber')
        ->section('content');
    }
}
