<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarberSchedule extends Model
{
    use HasFactory;

    protected $fillable = ['barber_id', 'day', 'start_time', 'end_time', 'status', 'transaction_id', 'delayed_until'];

    public function barber()
    {
        return $this->belongsTo(User::class, 'barber_id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
}
