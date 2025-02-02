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
    public $filter = 'pending';


    public $day;
    public $month;
    public $year;
    public $filterType;

    public function mount()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->user = Auth::user();

        $this->loadSchedules();
    }

    public function setFilter($status)
    {
        $this->filter = $status;

        $this->loadSchedules();
    }

    public function updatedFilterType($value)
    {
        $this->day = null;
        $this->month = null;
        $this->year = null;
        $this->loadSchedules();
    }

    public function loadSchedules()
    {
        $query = BarberSchedule::where('barber_id', $this->user->id)
            ->with(['transaction.details.service', 'transaction.customer']);

        // Filter status
        if ($this->filter === 'done') {
            $query->where('status', 'done');
        } else {
            $query->where('status', 'pending');
        }

        // Filter tanggal
        $query->when($this->filterType === 'daily' && $this->day, function ($q) {
            $q->whereDate('day', $this->day);
        });

        $query->when($this->filterType === 'monthly' && $this->month, function ($q) {
            $year = $this->year ?? date('Y');
            $q->whereYear('day', $year)->whereMonth('day', $this->month);
        });

        $query->when($this->filterType === 'yearly' && $this->year, function ($q) {
            $q->whereYear('day', $this->year);
        });

        // Urutkan hasil
        $query->orderByRaw("FIELD(status, 'approved') DESC")
            ->orderBy('day', 'desc');

        // Ambil data dan format
        $schedules = $query->get()->map(function ($schedule) {
            $schedule->formatted_date = $schedule->day
                ? \Carbon\Carbon::parse($schedule->day)->format('d F Y')
                : 'Tanggal Tidak Tersedia';

            $schedule->formatted_time = $schedule->start_time && $schedule->end_time
                ? \Carbon\Carbon::parse($schedule->start_time)->format('H:i') . ' - ' . \Carbon\Carbon::parse($schedule->end_time)->format('H:i')
                : 'Waktu Tidak Tersedia';

            $schedule->customer_name = $schedule->transaction->customer->name ?? 'Nama Tidak Tersedia';

            return $schedule;
        });

        if ($this->filter === 'done') {
            $this->doneSchedules = $schedules;
        } else {
            $this->pendingSchedules = $schedules;
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
