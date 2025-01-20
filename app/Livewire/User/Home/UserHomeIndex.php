<?php

namespace App\Livewire\User\Home;

use Livewire\Component;
use App\Models\Service;
use App\Models\Barber;
use App\Models\BarberSchedule;
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
    public $times = ['09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00', '21:30', '22:00', '22:30'];

    public $transaction;
    public $showModaltime = false;

    public $barber_id;
    public $tanggal;
    public $time;
    public $transactionId;

    public $takenTimes = [];

    public function mount()
    {
        if (auth()->check()) {
            $this->user = Auth::user();
            $this->name = $this->user->name;
            $this->image = $this->user->image;

            // Ambil data yang sesuai dengan pengguna yang sedang login
            $this->banners = ImageBanner::where('status', 'active')->get();
            $this->services = Service::where('status', 'active')->get();
            $this->barbers = Barber::where('status', 'active')->get();
            $this->trends = Tren::where('status', 'active')->get();
            $this->discounts = Discount::where('status', 'active')->with('service')->get();

            // Ambil transaksi yang sesuai dengan pengguna yang sedang login
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

            // Update transaksi yang statusnya 'pending' lebih dari 10 menit dan tidak ada bukti_image
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

        $this->checkApprovedTransaction();
        $this->loadTakenTimes();
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

    public function checkApprovedTransaction()
    {
        // Ambil waktu sekarang
        $currentTime = Carbon::now();
        // Tentukan rentang waktu, 3 menit sebelumnya dan 3 menit setelahnya
        $startTime = $currentTime->copy()->subMinutes(10);  // 3 menit sebelumnya
        $endTime = $currentTime->copy()->addMinutes(15);    // 3 menit setelahnya

        // Mencari transaksi yang sesuai dengan kondisi
        $this->transaction = Transaction::where('status', 'approved')
            ->whereDate('appointment_date', $currentTime->toDateString())  // Pastikan appointment_date sama dengan hari ini
            ->whereBetween('time', [$startTime->format('H:i'), $endTime->format('H:i')])  // Pastikan 'time' berada dalam rentang waktu
            ->first();  // Ambil transaksi pertama yang sesuai

        if ($this->transaction) {
            // Jika transaksi ditemukan, buka modal
            $this->showModaltime = true;
            $this->dispatch('open-modal');
        }
    }

    public function checkAndUpdateStatus()
    {
        // Ambil waktu sekarang
        $now = Carbon::now();
        // Simpan waktu batas 10 menit yang lalu
        $thresholdTime = $now->subMinutes(10);

        // Ambil semua transaksi dengan status 'approved' yang appointment_date dan time lebih dari 10 menit lalu
        $transactions = Transaction::whereRaw("STR_TO_DATE(CONCAT(appointment_date, ' ', time), '%Y-%m-%d %H:%i:%s') < ?", [$thresholdTime])
            ->where('status', 'approved')
            ->get();

        foreach ($transactions as $transaction) {
            // Update status transaksi menjadi 'canceled'
            $transaction->status = 'canceled';
            $transaction->save();

            // Ambil barber schedule terkait dan ubah status menjadi 'done'
            $barberSchedule = BarberSchedule::where('transaction_id', $transaction->id)->first();
            if ($barberSchedule) {
                $barberSchedule->status = 'done';
                $barberSchedule->save();
            }
        }
    }


    public function markAsArrived()
    {
        if ($this->transaction) {
            $this->transaction->status = 'arrived';
            $this->transaction->save();

            $this->alert('success', 'Berhasil!', [
                'text' => 'Jawaban telah dikonfirmasi.'
            ]);
        } else {
            $this->alert('error', 'Gagal!', [
                'text' => 'Tidak ada transaksi untuk diperbarui.'
            ]);
        }
        $this->dispatch('close-modal');
        return redirect("/");
    }



    public function setTime($selectedTime)
    {
        $this->time = $selectedTime;
    }


    public function notArrived($transactionId, $newTime)
    {
        // Validasi input
        if (!$transactionId || !$newTime) {
            session()->flash('error', 'Transaction ID and new time are required.');
            return;
        }

        //dd($transactionId, $newTime);

        // Update waktu transaksi
        $updated = Transaction::where('id', $transactionId)->update(['time' => $newTime]);

        if ($updated) {
            $this->alert('success', 'Berhasil!', [
                'text' => 'Oke, kedatangan anda tetap kami tunggu hingga 10 menit.'
            ]);
        } else {
            $this->alert('error', 'Gagal', [
                'text' => 'Terjadi kesalahan saat memperbarui waktu transaksi.'
            ]);
        }
        $this->dispatch('close-modal');
        return redirect("/");
    }


    public function cancelTransaction()
    {
        if ($this->transaction) {
            $this->transaction->status = 'canceled';
            $this->transaction->save();

            \App\Models\BarberSchedule::where('transaction_id', $this->transaction->id)
                ->update(['status' => 'done']);

            // Menampilkan alert success
            $this->alert('success', 'Berhasil!', [
                'text' => 'Anda berhasil mengcancel jadwal.'
            ]);
        } else {
            $this->alert('error', 'Gagal!', [
                'text' => 'Tidak ada transaksi untuk dibatalkan.'
            ]);
        }

        // Menutup modal
        $this->dispatch('close-modal');
        return redirect("/");
    }

    public function loadTakenTimes()
    {
        // Mengambil semua transaksi yang sudah ada untuk barber dan tanggal yang dipilih
        $this->takenTimes = Transaction::where('barber_id', $this->barber_id)
            ->whereDate('appointment_date', $this->tanggal)
            ->whereIn('status', ['pending', 'approved'])
            ->pluck('time')
            ->map(function ($time) {
                return Carbon::parse($time)->format('H:i');
            })
            ->toArray();

        // Menyaring waktu yang harus di-disable (sudah diambil atau waktu di masa lalu jika hari ini)
        $this->takenTimes = collect($this->times)->filter(function ($time) {
            // Tandai waktu sebagai terambil jika ada di takenTimes
            if (in_array($time, $this->takenTimes)) {
                return true;
            }

            // Jika tanggal yang dipilih adalah hari ini, tandai waktu sebelum sekarang sebagai terambil
            if (Carbon::parse($this->tanggal)->isToday()) {
                return Carbon::parse($time)->format('H:i') < Carbon::now()->format('H:i');
            }

            // Jika bukan hari ini, hanya tandai waktu yang sudah diambil
            return false;
        })->values()->toArray();

        // Menampilkan daftar waktu yang sudah terambil
        // dd($this->takenTimes);
    }

    public function render()
    {
        return view('livewire.user.home.user-home-index', [
            'barbers' => $this->barbers,
            'takenTimes' => $this->takenTimes,
        ])
            ->extends('layouts.app')
            ->section('content');
    }
}
