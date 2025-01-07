<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'status',
        'bukti_image',
        'payment_method',
        'service_id',
        'harga',
        'total_harga',
    ];

    protected $casts = [
        'status' => 'string',
        'appointment_date' => 'datetime',
        'time' => 'datetime:H:i:s',
    ];

    // Relasi ke DetailTransaction
    public function details()
    {
        return $this->hasMany(DetailTransaction::class, 'transactions_id');
    }

    // Relasi ke tabel services
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    // Relasi ke Customer (User)
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    // Relasi ke Barber (User)
    public function barber()
    {
        return $this->belongsTo(Barber::class, 'barber_id');
    }

    public function barberSchedules()
    {
        return $this->hasMany(BarberSchedule::class);
    }
}
