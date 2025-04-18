<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDiscount extends Model
{
    use HasFactory;

    protected $table = 'user_discounts';

    protected $fillable = [
        'user_id',
        'discount_id',
    ];

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan model Discount
    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }
}
