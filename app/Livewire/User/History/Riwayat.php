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
    public $filterType = 'daily';

    // public $startDate;
    // public $endDate;


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

    public function filterTransactions()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $customerId = auth()->user()->id;

        // Variabel untuk menentukan apakah filter tanggal digunakan
        $filterDateApplied = false;

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
            ->when($this->startDate && $this->endDate, function ($query) use (&$filterDateApplied) {
                // Filter berdasarkan rentang tanggal
                $query->whereBetween('appointment_date', [$this->startDate, $this->endDate]);

                // Set filter tanggal diterapkan
                $filterDateApplied = true;
            })
            ->orderByRaw("FIELD(status, 'approved') DESC")
            ->orderBy('created_at', 'desc')
            ->get();

        // Menampilkan alert hanya jika filter tanggal digunakan
        if ($filterDateApplied) {
            $this->alert('success', 'Berhasil!', [
                'text' => 'Filter tanggal telah diterapkan.'
            ]);
        }

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


    public function setFilter($status)
    {
        $this->filter = $status;
        $this->filterTransactions();
    }

    public function swipeFilter($direction)
    {
        $keys = array_keys($this->statuses); // Ambil semua kunci filter
        $currentIndex = array_search($this->filter, $keys);

        if ($direction === 'next' && $currentIndex < count($keys) - 1) {
            // Jika swipe kiri, pindah ke filter berikutnya
            $this->filter = $keys[$currentIndex + 1];
        } elseif ($direction === 'previous' && $currentIndex > 0) {
            // Jika swipe kanan, pindah ke filter sebelumnya
            $this->filter = $keys[$currentIndex - 1];
        }

        $this->filterTransactions(); // Perbarui daftar transaksi
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
