<?php

namespace App\Livewire\User\Booking;

use App\Models\Discount;
use App\Models\ImageBanner;
use Livewire\Component;
use App\Models\Service;
use App\Models\UserDiscount;
use Illuminate\Support\Facades\Session;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Bookingdetail extends Component
{
    use LivewireAlert;

    public $services = [];
    public $banners = [];
    public $discounts = [];

    public function mount()
    {
        $this->services = Service::where('status', 'active')->get();
        $this->banners = ImageBanner::where('status', 'active')->get();
        $this->discounts = Discount::where('status', 'active')->with('service')->get();
    }

    public function selectDiscount($discountId)
    {
        $userId = auth()->id();

        // Cek apakah user sudah menggunakan diskon ini
        $existingDiscount = UserDiscount::where('user_id', $userId)
            ->where('discount_id', $discountId)
            ->first();

        if ($existingDiscount) {
            $this->alert('error', 'Gagal!', [
                'text' => 'Anda sudah menggunakan diskon ini.'
            ]);
            return;
        }

        // Temukan diskon dan simpan ke sesi
        $discount = Discount::find($discountId);

        if ($discount) {
            // Simpan ke sesi
            Session::put('selected_discount', [
                'id' => $discount->id,
                'name' => $discount->name,
                'description' => $discount->description,
                'image' => $discount->image,
                'discount_percentage' => $discount->discount_percentage,
            ]);

            // Simpan ke tabel user_discounts
            UserDiscount::create([
                'user_id' => $userId,
                'discount_id' => $discountId,
            ]);

            $this->alert('success', 'Berhasil!', [
                'text' => 'Diskon telah diterapkan.'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.user.booking.Booking')
            ->extends('layouts.app')
            ->section('content');
    }
}
