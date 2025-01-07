<?php

namespace App\Livewire\Barber\Home;

use App\Models\Service;
use Livewire\Component;

class Trendetail extends Component
{
    public $service;
    public $services = [];
    public $serviceId;
    public $currentPrice; // Properti untuk menyimpan harga layanan

    // Method mount menerima parameter serviceId dari route
    public function mount($serviceId)
    {
        $this->serviceId = $serviceId;
        $this->service = Service::findOrFail($this->serviceId);
        $this->services = Service::all();
    }

    public function render()
    {
        return view('livewire.barber.home.trendetail')
        ->extends('layouts.barber')
        ->section('content');
    }
}
