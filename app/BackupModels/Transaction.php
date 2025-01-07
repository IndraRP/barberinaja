<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'barber_id',
        'name_customer',
        'phone_number',
        'appointment_date',
        'time',
        'payment_method',
        'status',
    ];

    // Relasi dengan model DetailTransaction
    public function details()
    {
        return $this->hasMany(DetailTransaction::class, 'transactions_id', 'id');
    }


    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    // Relasi dengan model Barber
    public function barber()
    {
        return $this->belongsTo(Barber::class, 'barber_id');
    }
}
