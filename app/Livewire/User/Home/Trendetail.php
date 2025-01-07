<?php

namespace App\Livewire\User\Home;

use Livewire\Component;
use App\Models\Tren;

class Trendetail extends Component
{
    public $trend; 
    public $trends = [];

    public function mount($id)
    {
        // Ambil tren berdasarkan ID
        $this->trend = Tren::findOrFail($id);
        $this->trends = Tren::all();
     
    }
    public function render()
    {
        return view('livewire.user.home.trendetail')
        ->extends('layouts.app')
        ->section('content');
    }
}
