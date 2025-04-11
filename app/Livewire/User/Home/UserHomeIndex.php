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
use Illuminate\Database\Console\Migrations\StatusCommand;
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

            $this->approvedTransactions = Transaction::where('customer_id', $this->user->id)
                ->where('status', 'approved')
                ->with('details.service', 'barber')
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

            $this->updateCanceledTransactions();
            $this->formatTransactionDates();
            $this->checkApprovedTransaction();
            if ($this->transactionId) {
                $this->loadTakenTimes($this->transactionId);
            }
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
            ->update([
                'status' => 'canceled',
                'canceled' => 'not_paid'
            ]);
    }

    public function formatTransactionDates()
    {
        $this->approvedTransactions = $this->approvedTransactions->map(function ($transaction) {
            $transaction->formatted_date = Carbon::parse($transaction->appointment_date)->isoFormat('dddd, YYYY-MM-DD');
            $transaction->formatted_time = Carbon::parse($transaction->time)->format('H:i');
            return $transaction;
        });

        $this->pendingTransactions = $this->pendingTransactions->map(function ($transaction) {
            $transaction->formatted_date = Carbon::parse($transaction->appointment_date)->isoFormat('dddd, YYYY-MM-DD');
            $transaction->formatted_time = Carbon::parse($transaction->time)->format('H:i');
            return $transaction;
        });

        $this->waitingConfirmationTransactions = $this->waitingConfirmationTransactions->map(function ($transaction) {
            $transaction->formatted_date = Carbon::parse($transaction->appointment_date)->isoFormat('dddd, YYYY-MM-DD');
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
            // Simpan ke sesi, termasuk service_id
            Session::put('selected_discount', [
                'id' => $discount->id,
                'name' => $discount->name,
                'description' => $discount->description,
                'image' => $discount->image,
                'discount_percentage' => $discount->discount_percentage,
                'service_id' => $discount->service_id, // Menyimpan service_id
            ]);

            $this->alert('success', 'Berhasil!', [
                'text' => 'Diskon telah diterapkan.'
            ]);
        }
    }

    public function checkApprovedTransaction()
    {
        $currentTime = Carbon::now();
        $startTime = $currentTime->copy()->addMinutes(15);
        $endTime = $currentTime->copy()->subMinutes(15);

        $this->transaction = Transaction::where('status', 'approved')
            ->whereDate('appointment_date', $currentTime->toDateString())
            ->whereBetween('time', [$endTime->format('H:i'), $startTime->format('H:i')])
            ->first();

        // Jika transaksi ditemukan, buka modal
        if ($this->transaction) {
            $this->showModaltime = true;
            $this->dispatch('open-modal');
        }

        //dd($endTime);

        $transaction = Transaction::where('status', 'approved')
            ->whereDate('appointment_date', '<', $currentTime->toDateString())
            ->first();

        if ($transaction) {
            $this->checkAndUpdateStatus($transaction);
        }

        // Function menghapus
        $transaction = Transaction::where('status', 'approved')
            ->whereDate('appointment_date', '<=', $currentTime->toDateString())
            ->whereTime('time', '<=', $currentTime->toTimeString())
            ->first();


        // Periksa jika transaksi ditemukan
        if ($transaction) {
            // Gabungkan appointment_date dan time untuk mendapatkan waktu transaksi
            $transactionTime = Carbon::parse($transaction->appointment_date)->setTimeFromTimeString($transaction->time);
            $transactionTimePlus10 = $transactionTime->addMinutes(15);

            if ($currentTime->greaterThanOrEqualTo($transactionTimePlus10)) {
                $this->checkAndUpdateStatus($transaction);
            }
        }
    }

    public function checkAndUpdateStatus($transaction)
    {
        // dd($transaction);
        // Logika untuk memperbarui status transaksi, misalnya mengubah status menjadi 'canceled'
        $transaction->status = 'canceled';
        $transaction->canceled = 'timeout';
        $transaction->save();

        // Memperbarui status jadwal barber jika ada
        $barberSchedule = BarberSchedule::where('transaction_id', $transaction->id)->first();
        if ($barberSchedule) {
            $barberSchedule->status = 'done';
            $barberSchedule->save();
        }
    }

    //Bisa
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

    //Bisa
    public function setTime($selectedTime)
    {
        $this->time = $selectedTime;
    }

    //Bisa
    public function notArrived($transactionId, $newTime)
    {

        $updated = Transaction::where('id', $transactionId)
            ->update([
                'time' => $newTime,
                'status' => 'approved',
            ]);

        if ($updated) {
            BarberSchedule::where('transaction_id', $transactionId)
                ->update([
                    'start_time' => $newTime,
                    'end_time' => Carbon::parse($newTime)->addMinutes(30)->format('H:i'),
                    'status' => 'pending',
                ]);
        }

        if ($updated) {
            $this->alert('success', 'Berhasil!', [
                'text' => 'Oke, kedatangan anda tetap kami tunggu.'
            ]);
        } else {
            $this->alert('error', 'Gagal', [
                'text' => 'Terjadi kesalahan saat memperbarui waktu transaksi.'
            ]);
        }
        $this->dispatch('close-modal');
        return redirect("/");
    }

    //Bisa
    public function cancelTransaction()
    {
        if ($this->transaction) {
            $this->transaction->status = 'canceled';
            $this->transaction->canceled = 'user_cancel';
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

    //Bisa
    public function loadTakenTimes($transactionId)
    {
        // Ambil transaksi berdasarkan transactionId
        $transaction = Transaction::find($transactionId);

        // Periksa apakah transaksi ditemukan
        if (!$transaction) {
            $this->alert('error', 'Gagal!', ['text' => 'Transaksi tidak ditemukan.']);
            return;
        }
        $this->tanggal = $this->tanggal ?: Carbon::now()->format('Y-m-d');
        $barber_id = $transaction->barber_id;

        // Ambil waktu yang sudah diambil berdasarkan barber_id
        $this->takenTimes = Transaction::where('barber_id', $barber_id)
            ->whereDate('appointment_date', $this->tanggal)
            ->whereIn('status', ['pending', 'approved'])
            ->pluck('time')
            ->map(function ($time) {
                return Carbon::parse($time)->format('H:i');
            })
            ->toArray();

        // dd($this->takenTimes);

        $this->takenTimes = collect($this->times)->filter(function ($time) {
            if (in_array($time, $this->takenTimes)) {
                return true;
            }

            if (Carbon::parse($this->tanggal)->isToday()) {
                return Carbon::parse($time)->format('H:i') < Carbon::now()->format('H:i');
            }

            return false;
        })->values()->toArray();
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
