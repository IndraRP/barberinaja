<?php

namespace App\Livewire\User\History;

use App\Models\Transaction;
use Livewire\Component;

class DetailRiwayat extends Component
{
    public $transactionId;

    public function mount($id)
    {
        $this->transactionId = $id;
    }

    public function render()
    {
        $transaction = Transaction::with('details.service')->find($this->transactionId);

        if (!$transaction) {
            abort(404);
        }
        return view('livewire.user.history.detail-riwayat', [
            'transaction' => $transaction,
        ])
            ->extends('layouts.app')
            ->section('content');
    }
}
