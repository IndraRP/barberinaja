<?php

namespace App\Livewire\User\Home;

use Livewire\Component;
use App\Models\Service;
use App\Models\Barber;
use App\Models\Transaction;
use App\Models\Tren;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserHomeIndex extends Component
{
    public $user;
    public $image;
    public $name;

    public $services = [];
    public $barbers = [];
    public $trends = [];
    public $approvedTransactions = [];
    public $pendingTransactions = [];
    public $waitingConfirmationTransactions = [];

    public function mount()
    {
        // Pastikan user sudah login
        if (auth()->check()) {
            // User sudah login
            $this->user = Auth::user();
            $this->name = $this->user->name;
            $this->image = $this->user->image;

            $this->services = Service::all();
            $this->barbers = Barber::all();
            $this->trends = Tren::all();

            // Ambil transaksi yang disetujui, pending, dan menunggu konfirmasi
            $this->approvedTransactions = Transaction::where('customer_id', $this->user->id)
                ->where('status', 'approved')
                ->with('details.service')
                ->get(); // Ini sudah mengembalikan koleksi Eloquent

            $this->pendingTransactions = Transaction::where('customer_id', $this->user->id)
                ->where('status', 'pending')
                ->whereNull('bukti_image')
                ->with('details.service')
                ->get(); // Koleksi Eloquent

            $this->waitingConfirmationTransactions = Transaction::where('customer_id', $this->user->id)
                ->where('status', 'pending')
                ->whereNotNull('bukti_image')
                ->with('details.service')
                ->get(); // Koleksi Eloquent

            // Format tanggal dan waktu
            $this->approvedTransactions = $this->approvedTransactions->map(function ($transaction) {
                $transaction->formatted_date = Carbon::parse($transaction->time)->isoFormat('dddd, YYYY-MM-DD');
                $transaction->formatted_time = Carbon::parse($transaction->time)->format('H:i');
                return $transaction;
            });

            $this->pendingTransactions = $this->pendingTransactions->map(function ($transaction) {
                $transaction->formatted_date = Carbon::parse($transaction->time)->isoFormat('dddd, YYYY-MM-DD');
                $transaction->formatted_time = Carbon::parse($transaction->time)->format('H:i');
                return $transaction;
            });

            $this->waitingConfirmationTransactions = $this->waitingConfirmationTransactions->map(function ($transaction) {
                $transaction->formatted_date = Carbon::parse($transaction->time)->isoFormat('dddd, YYYY-MM-DD');
                $transaction->formatted_time = Carbon::parse($transaction->time)->format('H:i');
                return $transaction;
            });

        } else {
            // Data default untuk user yang belum login
            $this->name = 'Guest';
            $this->services = Service::all();
            $this->barbers = Barber::all();
            $this->trends = Tren::all();
        }
    }

    public function render()
    {
        return view('livewire.user.home.user-home-index')
            ->extends('layouts.app')
            ->section('content');
    }
}
