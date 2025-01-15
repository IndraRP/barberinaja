<?php

namespace App\Livewire\User\History;

use App\Models\Transaction;
use Livewire\Component;

class Riwayat extends Component
{
    public $transactions;
    public $filter = 'confirmed'; 

    public function mount()
    {
        $this->filterTransactions();
    }

    public function filterTransactions()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
    
        $customerId = auth()->user()->id;
    
        // Ambil transaksi berdasarkan filter status
        $this->transactions = Transaction::with('details.service', 'barber')
            ->where('customer_id', $customerId)
            ->where(function($query) {
                if ($this->filter == 'confirmed') {
                    // Menunggu Pembayaran
                    $query->where('status', 'pending')->whereNull('bukti_image');
                } elseif ($this->filter == 'pending') {
                    // Menunggu Konfirmasi
                    $query->where('status', 'pending')->whereNotNull('bukti_image');
                } else {
                    // Filter lainnya
                    $query->where('status', $this->filter);
                }
            })
            ->orderByRaw("FIELD(status, 'approved') DESC")
            ->orderBy('created_at', 'desc')  // Urutkan berdasarkan created_at
            ->get();
    
        // Update transaksi yang statusnya 'pending' lebih dari 10 menit
        $now = now();
        Transaction::where('customer_id', $customerId)
            ->where('status', 'pending')
            ->where('created_at', '<', $now->subMinutes(10)) // lebih dari 10 menit
            ->whereNull('bukti_image') // cek jika bukti_image kosong
            ->update(['status' => 'canceled']);
    }
    
    public function setFilter($status)
    {
        $this->filter = $status;
        $this->filterTransactions();
    }

    public function render()
    {
        return view('livewire.user.history.riwayat', [
            'statuses' => [
                'confirmed' => 'Menunggu Pembayaran',
                'pending' => 'Menunggu Konfirmasi',
                'approved' => 'Menunggu Hari',
                'completed' => 'Selesai',
                'canceled' => 'Dibatalkan',
            ],
        ])
        ->extends('layouts.app')
        ->section('content');
    }
}
