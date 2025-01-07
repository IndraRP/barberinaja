<?php

namespace App\Livewire\Barber\History;

use App\Models\BarberSchedule;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Riwayat extends Component
{

    public $user;
    public $doneSchedules = [];

    public function mount()
    {
            // Pastikan user sudah login
            if (!auth()->check()) {
                return redirect()->route('login');
            }
    
            // Ambil data user yang sedang login
            $this->user = Auth::user();

        // Ambil jadwal dengan status 'done' untuk barber yang sedang login
        $this->doneSchedules = BarberSchedule::where('barber_id', $this->user->id)
            ->where('status', 'done')
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


    public function render()
    {
        return view('livewire.barber.history.riwayat', [
            'doneSchedules' => $this->doneSchedules,
        ])
            ->extends('layouts.barber')
            ->section('content');
    }
}