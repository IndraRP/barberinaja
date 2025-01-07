<?php

namespace App\Livewire\User\History;

use App\Models\Transaction;
use Livewire\Component;

class Riwayat extends Component
{
    public $filter = 'pending';  
    public $transactions = [];  

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

         $this->transactions = Transaction::with('details.service', 'barber')
            ->where('customer_id', $customerId)
            ->where('status', $this->filter)
            ->orderByRaw("FIELD(status, 'approved') DESC")
            ->orderBy('appointment_date', 'desc') 
            ->get();
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
                'pending' => 'Menunggu Pembayaran',
                'approved' => 'Menunggu Hari',
                'completed' => 'Selesai',
                'canceled' => 'Dibatalkan',
            ],
        ])
            ->extends('layouts.app') 
            ->section('content'); 
    }
}
