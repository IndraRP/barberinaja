<?php

namespace App\Livewire\User\Barber;

use Livewire\Component;
use App\Models\Barber;

class Barberdetail extends Component
{
    public $barber; 
    public $barbers = [];

    public function mount($id)
    {
        // Ambil tren berdasarkan ID
        $this->barber = Barber::findOrFail($id);
        $this->barbers = Barber::all();
    }

    public function render()
    {
        return view('livewire.user.barber.barberdetail')
        ->extends('layouts.app')
        ->section('content');
    }
}
