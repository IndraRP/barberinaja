<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaction extends Model
{
    use HasFactory;

    // Menentukan kolom yang bisa diisi secara massal
    protected $fillable = [
        'transactions_id',
        'service_id',  
        'harga',
        'total_harga',
    ];

    // Relasi dengan model Transaction
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transactions_id');        
    }

    // Relasi dengan model Service
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
