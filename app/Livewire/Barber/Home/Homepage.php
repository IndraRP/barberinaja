<?php

namespace App\Livewire\Barber\Home;

use App\Models\BarberSchedule;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Homepage extends Component
{
    public $user;
    public $image;
    public $name;
    public $services;
    public $transactions;

    public $pendingSchedules = [];
    public $selectedSchedule;

    public function mount()
    {
        // Pastikan user sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Ambil data user yang sedang login
        $this->user = Auth::user();
        $this->name = $this->user->name;
        $this->image = $this->user->image;
        $this->services = Service::all();
        $this->transactions = Transaction::all();

        // Ambil jadwal dengan status 'pending' untuk barber yang sedang login
        $this->pendingSchedules = BarberSchedule::where('barber_id', $this->user->id)
            ->where('status', 'pending')
            ->with(['transaction.details.service']) // Memuat relasi transaksi dan detail layanan
            ->get()
            ->map(function ($schedule) {
                // Format kolom `day` sebagai tanggal
                $schedule->formatted_date = $schedule->day
                    ? \Carbon\Carbon::parse($schedule->day)->format('d F Y')
                    : 'Tanggal Tidak Tersedia';

                // Format waktu mulai dan selesai
                $schedule->formatted_time = $schedule->start_time && $schedule->end_time
                    ? \Carbon\Carbon::parse($schedule->start_time)->format('H:i') . ' - ' . \Carbon\Carbon::parse($schedule->end_time)->format('H:i')
                    : 'Waktu Tidak Tersedia';

                $schedule->customer_name = $schedule->transaction->customer->name ?? 'Nama Tidak Tersedia';

                return $schedule;
            });
    }


    public function selectSchedule($id)
    {
        // Ambil data jadwal berdasarkan ID dengan relasi yang diperlukan
        $schedule = BarberSchedule::where('id', $id)
            ->with(['transaction.details.service', 'transaction.customer'])
            ->first();

        // Format data seperti di $pendingSchedules
        if ($schedule) {
            $schedule->formatted_date = $schedule->day
                ? \Carbon\Carbon::parse($schedule->day)->format('d F Y')
                : 'Tanggal Tidak Tersedia';

            $schedule->formatted_time = $schedule->start_time && $schedule->end_time
                ? \Carbon\Carbon::parse($schedule->start_time)->format('H:i') . ' - ' . \Carbon\Carbon::parse($schedule->end_time)->format('H:i')
                : 'Waktu Tidak Tersedia';

            $schedule->customer_name = $schedule->transaction->customer->name ?? 'Nama Tidak Tersedia';

            $this->selectedSchedule = $schedule;
        } else {
            $this->selectedSchedule = null;
        }
    }

    public function markAsDone()
    {
        if ($this->selectedSchedule) {
            // Update status pada BarberSchedule menjadi 'done'
            $this->selectedSchedule->update(['status' => 'done']);
    
            // Update status pada Transaction terkait menjadi 'completed'
            $transaction = $this->selectedSchedule->transaction;
            if ($transaction) {
                $transaction->update(['status' => 'completed']);
            }
    
            // Arahkan ke halaman history setelah selesai
            return redirect()->route('history_barber');
        }
    }
    

    public function render()
    {
        return view('livewire.barber.home.homepage', [
            'pendingSchedules' => $this->pendingSchedules,
        ])
            ->extends('layouts.barber')
            ->section('content');
    }
}
