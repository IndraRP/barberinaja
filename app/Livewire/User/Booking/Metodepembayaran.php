<?php

namespace App\Livewire\User\Booking;

use Livewire\Component;
use App\Models\Transaction;
use App\Models\DetailTransaction;
use App\Models\Service;
use App\Models\Barber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Metodepembayaran extends Component
{
    public $barber_id;
    public $barber;
    public $detail;
    public $serviceId;
    public $servicePrice;
    public $service;
    public $showModal = false;
    public $transactionId;
    public $metode_pembayaran;

    protected $rules = [
        'metode_pembayaran' => 'required',
    ];

    public function mount()
    {
        // Cek dan ambil data dari sesi
        $this->detail = Session::get('detail', [
            'name' => '',
            'phone_number' => '',
            'tanggal' => '',
            'barber' => null,
            'metode_pembayaran' => null,
        ]);
    
        $serviceDetail = Session::get('service_detail', null);
        if ($serviceDetail) {
            $this->serviceId = $serviceDetail['service_id'];
            $this->servicePrice = (float) $serviceDetail['service_price'];
            $this->service = Service::find($this->serviceId);
        } else {
            return redirect('/bookingdetail');
        }
    
        if (empty($this->detail)) {
            return redirect('/bookingdetail');
        }
    
        $this->metode_pembayaran = $this->detail['metode_pembayaran'] ?? null;
        $this->barber = $this->detail['barber_name'];
        $this->barber_id = $this->detail['barber'];
    
        if (!auth()->check()) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }
    
        // Biaya admin dan aplikasi
        $biayaAdmin = 1000;
        $biayaAplikasi = 1000;
    
        // Ambil total pembayaran saat ini
        $totalPembayaran = Session::get('total_pembayaran', 0);
    
        // Cek apakah total sudah mencakup biaya admin dan aplikasi
        if ($totalPembayaran === 0) {
            $total = $this->servicePrice + $biayaAdmin + $biayaAplikasi;
            Session::put('total_pembayaran', $total);
        } else {
            // Total pembayaran sudah ada, jadi tidak perlu menambahkan biaya lagi
            Session::put('total_pembayaran', $totalPembayaran);
        }
    }
    
    public function bayar()
    {
        $totalPembayaran = Session::get('total_pembayaran', 0);

        // Pastikan kita mengambil ID barber dan data lainnya dengan benar
        $transaction = Transaction::create([
            'customer_id' => auth()->user()->id,
            'barber_id' => $this->barber_id, // Gunakan barber_id
            'name_customer' => $this->detail['name'],
            'phone_number' => $this->detail['phone_number'],
            'appointment_date' => $this->detail['tanggal'],
            'time' => $this->detail['time'],
            'status' => 'pending',
        ]);

        // Simpan detail transaksi
        DetailTransaction::create([
            'transactions_id' => $transaction->id,
            'service_id' => $this->serviceId,
            'harga' => $this->servicePrice, // Harga layanan tetap ada
            'total_harga' => $totalPembayaran, // Total yang sudah dihitung di session
        ]);

        // Simpan ID transaksi ke properti Livewire
        $this->transactionId = $transaction->id;

        // Hapus sesi setelah transaksi selesai
        Session::forget('detail');
        Session::forget('service_detail');
        Session::forget('total_pembayaran');
    }


    public function render()
    {
        // Pastikan service tersedia sebelum render view
        if (!$this->service) {
            return view('livewire.user.booking.metodepembayaran', [
                'detail' => $this->detail,
                'service' => null,
                'barber' => $this->barber,
                'servicePrice' => $this->servicePrice,
            ])
                ->extends('layouts.app')
                ->section('content');
        }

        return view('livewire.user.booking.metodepembayaran', [
            'detail' => $this->detail,
            'service' => $this->service,
            'barber' => $this->barber,
            'servicePrice' => $this->servicePrice,
        ])
            ->extends('layouts.app')
            ->section('content');
    }
}
