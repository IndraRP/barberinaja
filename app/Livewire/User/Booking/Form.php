<?php

namespace App\Livewire\User\Booking;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Barber;
use App\Models\BarberSchedule;
use App\Models\Transaction;
use App\Models\User;

class Form extends Component
{
    public $name;
    public $phone_number;
    public $barber_id;
    public $tanggal;
    public $time;
    public $times = ['09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00', '21:30', '22:00', '22:30'];
    public $barbers = [];
    public $takenTimes = [];

    public function mount($id)
    {
        $this->barbers = Barber::whereBetween('id', [28, 32])->get();

        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        if ($user) {
            $this->name = $user->name;
            $this->phone_number = $user->phone_number ?? '';
            $this->barbers = Barber::all();
        }
    }

    protected $rules = [
        'name' => 'required|string|max:255',
        'phone_number' => 'required|numeric',
        'barber_id' => 'required|exists:barbers,id',
        'tanggal' => 'required|date',
        'time' => 'required|string',
    ];

    protected $messages = [
        'name.required' => 'Nama wajib diisi.',
        'phone_number.required' => 'Nomor telepon wajib diisi.',
        'barber_id.required' => 'Silakan pilih barber.',
        'tanggal.required' => 'Tanggal wajib diisi.',
        'time.required' => 'Silakan pilih waktu.',
    ];



    public function updatedTanggal()
    {
        $this->loadTakenTimes();
    }

    public function loadTakenTimes()
    {
        $this->takenTimes = Transaction::where('barber_id', $this->barber_id)
            ->whereDate('appointment_date', $this->tanggal)
            ->whereIn('status', ['pending', 'approved']) // Filter status pending dan approved
            ->pluck('time')
            ->map(function ($time) {
                return \Carbon\Carbon::parse($time)->format('H:i');
            })
            ->toArray();
    }


    public function setTime($selectedTime)
    {
        logger("Waktu dipilih: " . $selectedTime);
        $this->time = $selectedTime;
    }

    public function submitBooking()
    {
        // dd($this->barber_id);
        $this->tanggal = date('Y-m-d 00:00:00', strtotime($this->tanggal));
        $this->validate();

        // Cek apakah sudah ada jadwal dengan status pending pada tanggal dan waktu yang dipilih
        $existingSchedule = BarberSchedule::where('barber_id', $this->barber_id)
            ->where('day', $this->tanggal)
            ->where('start_time', $this->time)
            ->where('status', 'pending')
            ->first();

        if ($existingSchedule) {
            session()->flash('error', 'Barber ini sudah memiliki jadwal pada waktu yang dipilih Silahkan Ubah Waktu.');
            return;
        }

        $barber = Barber::find($this->barber_id);

        $session = [
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'barber' => $barber->id,
            'barber_name' => $barber->name,
            'barber_image' => $barber->image,
            'tanggal' => $this->tanggal,
            'time' => $this->time,
        ];

        // Simpan data pemesanan ke sesi
        session(['detail' => $session]);

        session()->flash('success', 'Pemesanan berhasil dilakukan.');
        // dd(session()->all());
        return redirect("/metodepembayaran");
    }



    public function render()
    {

        return view('livewire.user.booking.form')
            ->extends('layouts.app')
            ->section('content');
    }
}



// public function updatedBarberId()
// {
//     // Ambil jadwal barber dengan status pending berdasarkan barber_id dan tanggal
//     $this->tanggal = date('Y-m-d', strtotime($this->tanggal));
//     $this->takenTimes = BarberSchedule::where('barber_id', $this->barber_id)
//         ->where('day', $this->tanggal)
//         ->where('status', 'pending')
//         ->pluck('start_time')
//         ->toArray();
        
//     $this->time = null;
// }

//   // Ambil jadwal barber dengan status pending berdasarkan barber_id dan tanggal
//   $takenTimes = BarberSchedule::where('barber_id', $this->barber_id)
//   ->where('day', $this->tanggal)
//   ->where('status', 'pending')
//   ->pluck('start_time')
//   ->toArray();

// , [
//     'takenTimes' => $takenTimes, // Kirim ke tampilan untuk pengecekan waktu
// ]

    // Mendapatkan barber yang dipilih
        // $barber = Barber::find($this->barber_id);

        // Debugging: pastikan nilai barber_id yang diteruskan benar
        // dd($barber);

        // $query = BarberSchedule::where('barber_id', $this->barber_id)
        // ->where('day', $this->tanggal)
        // ->where('start_time', $this->time)
        // ->where('status', 'pending');
        // logger("Pemesanan data: ", ['barber_id' => $this->barber_id, 'tanggal' => $this->tanggal, 'time' => $this->time]);

        // dd($query->toSql(), $query->getBindings()); // Debug query SQL yang dijalankan


        // Menyimpan data pemesanan ke sesi