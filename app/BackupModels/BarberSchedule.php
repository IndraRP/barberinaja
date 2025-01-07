<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarberSchedule extends Model
{
    use HasFactory;

    protected $fillable = ['barber_id', 'day', 'start_time', 'end_time'];

    public function barber()
    {
        return $this->belongsTo(User::class, 'barber_id');
    }
}
