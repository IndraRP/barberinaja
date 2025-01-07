<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaction extends Model
{
    use HasFactory;

    protected $table = 'detail_transactions';

    protected $fillable = [
        'transactions_id',
        'service_id',
        'harga',
        'total_harga',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'total_harga' => 'decimal:2',
    ];

    // Relasi ke Transaction
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transactions_id', 'id');
    }

    // Relasi ke Service
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
