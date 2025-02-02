<?php

namespace App\Livewire\User\Booking;

use Livewire\Component;
use App\Models\Transaction;
use App\Models\DetailTransaction;
use App\Models\Service;
use App\Models\Barber;
use App\Models\Discount;
use App\Models\UserDiscount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class Metodepembayaran extends Component
{
    use LivewireAlert;
    public $barber_id;
    public $barber;
    public $detail;
    public $serviceId;
    public $servicePrice;
    public $service;
    public $showModal = false;
    public $transactionId;
    public $metode_pembayaran;
    public $selected_discount;

    public $nomer_rekening;

    protected $rules = [
        'metode_pembayaran' => 'required',
    ];

    public function mount()
    {
        //dd(session()->all());
        // Ambil data dari sesi
        $this->detail = Session::get('detail', [
            'name' => '',
            'phone_number' => '',
            'tanggal' => '',
            'barber' => null,
            'metode_pembayaran' => null,
        ]);

        // $this->selected_discount = Session::get('selected_discount', []);
        $this->selected_discount = Session::get('selected_discount', []);

        $serviceDetail = Session::get('service_detail', null);
        if ($serviceDetail && isset($serviceDetail['service_id'], $serviceDetail['service_price'])) {
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
        $this->barber = $this->detail['barber_name'] ?? null;
        $this->barber_id = $this->detail['barber'] ?? null;



        // Cek jika ada diskon yang dipilih dan periksa kecocokan service_id
        if ($this->selected_discount) {
            // Cek apakah service_id diskon cocok dengan service_id layanan
            if (isset($this->selected_discount['service_id']) && (int)$this->selected_discount['service_id'] !== (int)$this->serviceId) {
                // Menandakan diskon tidak berlaku
                $this->selected_discount['disabled'] = true;
            } else {
                // Diskon aktif jika ID cocok
                $this->selected_discount['disabled'] = false;
            }
        }

        if (!auth()->check()) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $biayaAdmin = 1000;
        $biayaAplikasi = 1000;

        // Cek dan hitung total pembayaran
        $totalPembayaran = $this->servicePrice + $biayaAdmin + $biayaAplikasi;

        // Jika ada diskon, kurangi harga dengan diskon
        if ($this->selected_discount && isset($this->selected_discount['discount_percentage']) && !$this->selected_discount['disabled']) {
            $discountAmount = $this->servicePrice * ((float)$this->selected_discount['discount_percentage'] / 100);
            $totalPembayaran = ($this->servicePrice - $discountAmount) + $biayaAdmin + $biayaAplikasi;
        }

        // Simpan total pembayaran ke session
        Session::put('total_pembayaran', $totalPembayaran);

        $this->nomer_rekening = '1234567890'; // Ganti dengan nilai yang sesuai

        // // Debugging
        // dd([
        //     'service_id' => $this->serviceId,
        //     'selected_discount_service_id' => $this->selected_discount['service_id'] ?? null,
        //     'discount_disabled' => $this->selected_discount['disabled'] ?? null,
        //     'total_pembayaran' => $totalPembayaran,
        // ]);
    }

    public function showAlert()
    {
        $this->alert('success', 'Berhasil!', [
            'text' => 'No. Rekening berhasil disalin'
        ]);
    }

    public function bayar($discountId = null)
    {
        // Ambil total pembayaran dari session
        $totalPembayaran = Session::get('total_pembayaran', 0);

        // Buat transaksi
        $transaction = Transaction::create([
            'customer_id'      => auth()->user()->id,
            'barber_id'        => $this->barber_id,
            'name_customer'    => $this->detail['name'],
            'phone_number'     => $this->detail['phone_number'],
            'appointment_date' => $this->detail['tanggal'],
            'time'             => $this->detail['time'] ?? '00:00',
            'status'           => 'pending',
        ]);

        // Simpan detail transaksi
        DetailTransaction::create([
            'transactions_id' => $transaction->id,
            'service_id'      => $this->serviceId,
            'harga'           => $this->servicePrice,
            'total_harga'     => $totalPembayaran,
        ]);

        // Hanya simpan data diskon jika $discountId valid (tidak null dan bukan 0)
        if (!empty($discountId) && $discountId != 0) {
            $discount = Discount::find($discountId);
            if (!$discount) {
                $this->alert('error', 'Diskon tidak ditemukan!');
                return;
            }
            UserDiscount::create([
                'user_id'     => auth()->id(),
                'discount_id' => $discountId,
            ]);
        }

        $this->transactionId = $transaction->id;
        $this->alert('success', 'Transaksi berhasil!');
    }


    public function hapus()
    {
        // Hapus sesi setelah transaksi selesai
        Session::forget('detail');
        Session::forget('selected_discount');
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
