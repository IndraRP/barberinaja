<?php

namespace App\Livewire\Barber\Home;

use App\Models\BarberSchedule;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Homepage extends Component
{
    use LivewireAlert;
    public $user;
    public $image;
    public $name;
    public $services;
    public $transactions;

    public $pendingSchedules = [];
    public $arrivedSchedules;
    public $selectedSchedule;

    public $showModal = false;
    public $transactionId;


    public function mount()
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Ambil data user yang sedang login
        $this->user = Auth::user();
        $this->name = $this->user->name;
        $this->image = $this->user->image;
        $this->services = Service::all();
        $this->transactions = Transaction::where('barber_id', $this->user->id)->get(); // Ambil transaksi hanya yang sesuai dengan barber_id

        $this->pendingSchedules = BarberSchedule::where('barber_id', $this->user->id)
            ->where('status', 'pending')
            ->with(['transaction.details.service'])
            ->get()
            ->map(function ($schedule) {
                // Format kolom day sebagai tanggal
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

        $this->arrivedSchedules = BarberSchedule::where('barber_id', $this->user->id)
            ->whereHas('transaction', function ($query) {
                $query->where('status', 'arrived');
            })
            ->with(['transaction.details.service', 'transaction.customer'])
            ->get()
            ->map(function ($schedule) {
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

        if ($this->arrivedSchedules->isNotEmpty()) {
            $this->selectedSchedule = $this->arrivedSchedules->first();

            if ($this->selectedSchedule->delayed_until) {
                $delayedUntil = \Carbon\Carbon::parse($this->selectedSchedule->delayed_until);
                if ($delayedUntil->isFuture()) {
                    $this->showModal = false;
                } else {
                    $this->showModal = true;
                    $this->alert('info', 'Waktu penundaan telah selesai, Anda dapat memulai pengerjaan.');
                }
            } else {
                $this->showModal = true;
            }
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
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

    public function startNow()
    {
        if ($this->selectedSchedule) {
            // Update status pada BarberSchedule menjadi 'done'
            $this->selectedSchedule->update(['status' => 'done']);

            // Update status pada Transaction terkait menjadi 'completed'
            $transaction = $this->selectedSchedule->transaction;
            if ($transaction) {
                $transaction->update(['status' => 'completed']);
            }

            // Tampilkan notifikasi sukses
            $this->alert('success', 'Berhasil!', [
                'text' => 'Anda berhasil mengerjakan ini.'
            ]);

            $this->dispatch('close-modal');
            return redirect("/home_barber");
        }
    }

    public function startLater()
    {
        // Simpan waktu penundaan (misalnya, 10 menit ke depan)
        $delayedUntil = \Carbon\Carbon::now()->addMinutes(1);

        // Pastikan ada schedule yang dipilih
        if ($this->selectedSchedule) {
            // Update jadwal yang dipilih untuk menunda pengerjaan
            $this->selectedSchedule->update(['delayed_until' => $delayedUntil]);

            // Pastikan perubahan masuk ke dalam database
            $this->selectedSchedule->refresh(); // Refresh untuk memastikan data terbaru

            // Tampilkan notifikasi sukses
            $this->alert('success', 'Berhasil!', [
                'text' => 'Oke, kita akan tunggu hingga 10 menit.'
            ]);

            // Tutup modal setelah aksi
            $this->dispatch('close-modal');
            return redirect("/home_barber");
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
