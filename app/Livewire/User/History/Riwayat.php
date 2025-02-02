<?php

namespace App\Livewire\User\History;

use App\Models\Transaction;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Riwayat extends Component
{
    use LivewireAlert;
    public $transactions;
    public $filter = 'all';
    public $statuses = [];

    public $day;
    public $month;
    public $year;
    public $filterType;

    public function mount()
    {
        $this->statuses = [
            'all' => 'Semua',
            'confirmed' => 'Menunggu Pembayaran',
            'pending' => 'Menunggu Konfirmasi',
            'approved' => 'Menunggu Hari',
            'completed' => 'Selesai',
            'canceled' => 'Dibatalkan',
        ];
        $this->filterTransactions();
    }

    public function updatedFilterType($value)
    {
        $this->day = null;
        $this->month = null;
        $this->year = null;
    }


    public function filterTransactions()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $customerId = auth()->user()->id;

        // Ambil transaksi sesuai filter
        $this->transactions = Transaction::with('details.service', 'barber')
            ->where('customer_id', $customerId)
            ->when($this->filter !== 'all', function ($query) {
                if ($this->filter == 'confirmed') {
                    $query->where('status', 'pending')->whereNull('bukti_image');
                } elseif ($this->filter == 'pending') {
                    $query->where('status', 'pending')->whereNotNull('bukti_image');
                } else {
                    $query->where('status', $this->filter);
                }
            })
            ->when($this->filterType === 'daily' && $this->day, function ($query) {
                $query->whereDate('appointment_date', $this->day); // Filter harian
            })
            ->when($this->filterType === 'monthly' && $this->month, function ($query) {
                $year = $this->year ?? date('Y');
                $query->whereYear('appointment_date', $year)
                    ->whereMonth('appointment_date', $this->month); // Filter bulanan
            })

            ->when($this->filterType === 'yearly' && $this->year, function ($query) {
                $query->whereYear('appointment_date', $this->year); // Filter tahunan
            })
            // ->orderByRaw("FIELD(status, 'approved') DESC")
            // ->orderBy('id', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();

        // Manipulasi status transaksi 'arrived' menjadi 'completed' saat menampilkan data
        $this->transactions->transform(function ($transaction) {
            if ($transaction->status === 'arrived') {
                $transaction->status = 'completed'; // Manipulasi status saat tampil, tanpa mengubah di DB
            }
            return $transaction;
        });

        // Fallback ke collection kosong jika tidak ada transaksi
        if ($this->transactions->isEmpty()) {
            $this->transactions = collect();
        }
    }

    public function setDateFilter($type)
    {
        $this->filterType = $type;

        // Reset nilai day, month, dan year saat jenis filter diubah
        $this->day = null;
        $this->month = null;
        $this->year = null;

        $this->filterTransactions();
    }


    public function setFilter($status)
    {
        $this->filter = $status;
        $this->filterTransactions();
    }

    public function render()
    {
        return view('livewire.user.history.riwayat', [
            'statuses' => $this->statuses ?: [], // fallback ke array kosong
        ])
            ->extends('layouts.app')
            ->section('content');
    }
}
