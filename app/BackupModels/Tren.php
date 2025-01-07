<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tren extends Model
{
    use HasFactory;

    // Tentukan nama tabel secara eksplisit
    protected $table = 'tren';

    // Daftar atribut yang dapat diisi
    protected $fillable = ['name', 'description', 'image'];
}
