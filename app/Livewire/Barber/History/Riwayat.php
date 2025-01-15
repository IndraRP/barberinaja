<?php

namespace App\Livewire\Barber\History;

use App\Models\BarberSchedule;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Riwayat extends Component
{
    public $user;
    public $doneSchedules = [];
    public $pendingSchedules = [];
    public $filter = 'pending'; // Menetapkan filter default

    public function mount()
    {
        // Pastikan user sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Ambil data user yang sedang login
        $this->user = Auth::user();

        // Load jadwal berdasarkan filter yang aktif
        $this->loadSchedules();
    }

    public function setFilter($status)
    {
        // Set status filter yang dipilih
        $this->filter = $status;

        // Reload jadwal sesuai filter
        $this->loadSchedules();
    }

    public function loadSchedules()
    {
        // Ambil jadwal berdasarkan filter yang dipilih
        if ($this->filter === 'done') {
            $this->doneSchedules = BarberSchedule::where('barber_id', $this->user->id)
                ->where('status', 'done')
                ->with(['transaction.details.service'])
                ->get()
                ->map(function ($schedule) {
                    $schedule->formatted_date = $schedule->day
                        ? \Carbon\Carbon::parse($schedule->day)->format('d F Y')
                        : 'Tanggal Tidak Tersedia';

                    $schedule->formatted_time = $schedule->start_time && $schedule->end_time
                        ? \Carbon\Carbon::parse($schedule->start_time)->format('H:i') . ' - ' . \Carbon\Carbon::parse($schedule->end_time)->format('H:i')
                        : 'Waktu Tidak Tersedia';

                    $schedule->customer_name = $schedule->transaction->customer->name ?? 'Nama Tidak Tersedia';

                    return $schedule;
                });
        } else {
            $this->pendingSchedules = BarberSchedule::where('barber_id', $this->user->id)
                ->where('status', 'pending')
                ->with(['transaction.details.service'])
                ->get()
                ->map(function ($schedule) {
                    $schedule->formatted_date = $schedule->day
                        ? \Carbon\Carbon::parse($schedule->day)->format('d F Y')
                        : 'Tanggal Tidak Tersedia';

                    $schedule->formatted_time = $schedule->start_time && $schedule->end_time
                        ? \Carbon\Carbon::parse($schedule->start_time)->format('H:i') . ' - ' . \Carbon\Carbon::parse($schedule->end_time)->format('H:i')
                        : 'Waktu Tidak Tersedia';

                    $schedule->customer_name = $schedule->transaction->customer->name ?? 'Nama Tidak Tersedia';

                    return $schedule;
                });
        }
    }

    public function render()
    {
        return view('livewire.barber.history.riwayat', [
            'doneSchedules' => $this->doneSchedules,
            'pendingSchedules' => $this->pendingSchedules,
        ])
            ->extends('layouts.barber')
            ->section('content');
    }
}
