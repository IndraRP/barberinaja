<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginPage extends Model
{
    use HasFactory;

    protected $table = 'login_page';  // Nama tabel

    protected $fillable = [
        'title',
        'image',
    ];
}
