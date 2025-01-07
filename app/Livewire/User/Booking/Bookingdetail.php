<?php

namespace App\Livewire\User\Booking;

use Livewire\Component;
use App\Models\Service;

class Bookingdetail extends Component
{

    public $services = [];

    public function mount()
    {
        $this->services = Service::all();
    }

    public function render()
    {
        return view('livewire.user.booking.Booking')
            ->extends('layouts.app')
            ->section('content');
    }
}
