<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Enums\UserRole; // Jika menggunakan Enum
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $guarded = ['id'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'role' => UserRole::class, // Cast enum 'role' menjadi instance UserRole
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relasi dengan BarberSchedules
    public function barberSchedules()
    {
        return $this->hasMany(BarberSchedule::class, 'barber_id');
    }

    public function discounts()
    {
        return $this->hasMany(UserDiscount::class);
    }


    // Relasi dengan Transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'customer_id');
    }

    // Scope untuk filter role
    public function scopeOwners($query)
    {
        return $query->where('role', UserRole::Owner->value); // Gunakan value dari enum
    }

    public function scopeBarbers($query)
    {
        return $query->where('role', UserRole::Barber->value); // Gunakan value dari enum
    }

    public function scopeCustomers($query)
    {
        return $query->where('role', UserRole::Customer->value); // Gunakan value dari enum
    }

    // Cek peran dengan konstanta/enum
    public function isOwner(): bool
    {
        return $this->role === UserRole::Owner; // Bandingkan dengan instance enum
    }

    public function isBarber(): bool
    {
        return $this->role === UserRole::Barber; // Bandingkan dengan instance enum
    }

    public function isCustomer(): bool
    {
        return $this->role === UserRole::Customer; // Bandingkan dengan instance enum
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
