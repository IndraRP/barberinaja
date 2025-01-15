<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    // Tentukan nama tabel secara eksplisit
    protected $table = 'discount';

    // Daftar atribut yang dapat diisi
    protected $fillable = ['name', 'description', 'image', 'status', 'discount_percentage', 'service_id'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function users()
    {
        return $this->hasMany(UserDiscount::class);
    }
}
