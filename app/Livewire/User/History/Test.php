<?php

namespace App\Livewire\User\History;

use Livewire\Component;
use App\Models\Transaction;

class Test extends Component
{

    public $transactions, $filter;

    public function mount($filter = 'all')
    {
        $this->filter = $filter;
        $this->filterTransactions();
    }
    public function render()
    {
        return view('livewire.user.history.test');
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
            ->orderByRaw("FIELD(status, 'approved') DESC")
            ->orderBy('created_at', 'desc')
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
}
