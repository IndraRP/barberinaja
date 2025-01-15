<?php

namespace App\Livewire\User\Home;

use Livewire\Component;
use App\Models\Service;
use App\Models\Barber;
use App\Models\Discount;
use App\Models\Transaction;
use App\Models\Tren;
use App\Models\ImageBanner;
use App\Models\UserDiscount;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class UserHomeIndex extends Component
{
    use LivewireAlert;

    public $user;
    public $image;
    public $name;

    public $services = [];
    public $barbers = [];
    public $trends = [];
    public $discounts = [];
    public $approvedTransactions = [];
    public $pendingTransactions = [];
    public $waitingConfirmationTransactions = [];
    public $banners = [];

    public function mount()
    {
        if (auth()->check()) {
            $this->user = Auth::user();
            $this->name = $this->user->name;
            $this->image = $this->user->image;

            $this->banners = ImageBanner::where('status', 'active')->get();
            $this->services = Service::where('status', 'active')->get();
            $this->barbers = Barber::where('status', 'active')->get();
            $this->trends = Tren::where('status', 'active')->get();
            $this->discounts = Discount::where('status', 'active')->with('service')->get();

            $this->approvedTransactions = Transaction::where('customer_id', $this->user->id)
                ->where('status', 'approved')
                ->with('details.service')
                ->get();

            $this->pendingTransactions = Transaction::where('customer_id', $this->user->id)
                ->where('status', 'pending')
                ->whereNull('bukti_image')
                ->with('details.service')
                ->get();

            $this->waitingConfirmationTransactions = Transaction::where('customer_id', $this->user->id)
                ->where('status', 'pending')
                ->whereNotNull('bukti_image')
                ->with('details.service')
                ->get();

            // Update transaksi yang statusnya 'pending' lebih dari 15 menit dan tidak ada bukti_image
            $this->updateCanceledTransactions();

            // Format tanggal dan waktu transaksi
            $this->formatTransactionDates();
        } else {
            $this->name = 'Guest';
            $this->banners = ImageBanner::where('status', 'active')->get();
            $this->services = Service::where('status', 'active')->get();
            $this->barbers = Barber::where('status', 'active')->get();
            $this->trends = Tren::where('status', 'active')->get();
            $this->discounts = Discount::where('status', 'active')->with('service')->get();
        }

    }

    public function updateCanceledTransactions()
    {
        $now = now();
        $canceledTransactions = Transaction::where('customer_id', $this->user->id)
            ->where('status', 'pending')
            ->where('created_at', '<', $now->subMinutes(10)) // lebih dari 10 menit
            ->whereNull('bukti_image') // cek jika bukti_image kosong
            ->update(['status' => 'canceled']); // update status menjadi 'canceled'
    }

    public function formatTransactionDates()
    {
        $this->approvedTransactions = $this->approvedTransactions->map(function ($transaction) {
            $transaction->formatted_date = Carbon::parse($transaction->time)->isoFormat('dddd, YYYY-MM-DD');
            $transaction->formatted_time = Carbon::parse($transaction->time)->format('H:i');
            return $transaction;
        });

        $this->pendingTransactions = $this->pendingTransactions->map(function ($transaction) {
            $transaction->formatted_date = Carbon::parse($transaction->time)->isoFormat('dddd, YYYY-MM-DD');
            $transaction->formatted_time = Carbon::parse($transaction->time)->format('H:i');
            return $transaction;
        });

        $this->waitingConfirmationTransactions = $this->waitingConfirmationTransactions->map(function ($transaction) {
            $transaction->formatted_date = Carbon::parse($transaction->time)->isoFormat('dddd, YYYY-MM-DD');
            $transaction->formatted_time = Carbon::parse($transaction->time)->format('H:i');
            return $transaction;
        });
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
        return view('livewire.user.home.user-home-index')
            ->extends('layouts.app')
            ->section('content');
    }
}
