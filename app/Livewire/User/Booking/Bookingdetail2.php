<?php

namespace App\Livewire\User\Booking;

use Livewire\Component;
use App\Models\Service;
use Illuminate\Support\Facades\Session;

class Bookingdetail2 extends Component
{
    public $service;
    public $services = [];
    public $serviceId;
    public $currentPrice;
    public $showConfirmationModal;

    // Method mount menerima parameter serviceId dari route
    public function mount($serviceId)
    {
        //dd(session()->all());
        // Session::forget('selected_discount');

        $this->serviceId = $serviceId;
        $this->service = Service::findOrFail($this->serviceId);
        $this->services = Service::all();
        $this->currentPrice = $this->service->price; // Sinkronkan harga saat mount
    }

    // Method updated untuk mendengarkan perubahan pada serviceId
    public function updatedServiceId($value)
    {
        $this->service = Service::findOrFail($value);
        $this->currentPrice = $this->service->price; // Perbarui harga saat serviceId berubah
        $this->dispatch('priceUpdated', $this->currentPrice); // Emit event untuk pembaruan harga
    }

    // Menyimpan service ke session
    public function saveServiceToSession()
    {
        $sessionData = [
            'service_id' => $this->service->id,
            'service_name' => $this->service->name,
            'service_price' => $this->service->price,
            'service_image' => $this->service->image,
        ];


        Session::put('service_detail', $sessionData);
        return redirect()->route('form', ['id' => $this->service->id]);
    }

    public function removeDiscountAndGoBack()
    {
        // Hapus session 'selected_discount'
        Session::forget('selected_discount');
        
        // Redirect atau kembali ke halaman sebelumnya
        return redirect()->route('previous.route'); // Ganti dengan rute yang sesuai
    }

    // Method untuk menutup modal konfirmasi
    public function closeConfirmationModal()
    {
        $this->showConfirmationModal = false;
    }


    // Method render untuk tampilan
    public function render()
    {
        return view('livewire.user.booking.Bookingdetail2')
            ->extends('layouts.app')
            ->section('content');
    }
}
