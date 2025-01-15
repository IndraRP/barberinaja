<?php

namespace App\Livewire\Barber\Booking;

use App\Models\Service;
use Livewire\Component;

class Layanan extends Component
{
    public $services = [];
    public $banners = [];

    public function mount()
    {
        $this->services = Service::all();
    }


    public function render()
    {
        return view('livewire.barber.booking.layanan')
        ->extends('layouts.barber')
        ->section('content');
    }
}
