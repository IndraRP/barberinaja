<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageBanner extends Model
{
    use HasFactory;

    protected $table = 'images_banner';

    protected $fillable = [
        'image',
        'status',
    ];
}
