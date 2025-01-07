<?php

namespace App\Livewire\User\Booking;

use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithFileUploads;
use Throwable;

class Konfirmasi extends Component
{
    use WithFileUploads;

    public $transaction;
    public $bukti_image;

    protected $messages = [
        'bukti_image.required' => 'File bukti pembayaran wajib diupload.',
        'bukti_image.image' => 'File harus berupa gambar.',
        'bukti_image.mimes' => 'Format gambar tidak didukung. Gunakan jpeg, png, jpg, gif, svg, atau webp.',
        'bukti_image.max' => 'Ukuran file maksimum adalah 2MB.',
    ];


    protected $rules = [
        'bukti_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp,JPG|max:2048', // Validasi file gambar
    ];

    public function mount($transactionId)
    {
        $this->transaction = Transaction::find($transactionId);

        if (!$this->transaction) {
            abort(404, 'Transaksi tidak ditemukan');
        }
    }

    public function confirmPayment()
    {
        $this->validate();
        if (!$this->bukti_image) {
            logger()->error('File tidak ditemukan saat validasi.');
            session()->flash('error', 'Harap upload file sebelum mengonfirmasi pembayaran.');
            return;
        }


        $path = $this->bukti_image->store('images/bukti_transaksi', 'public');

        $this->transaction->bukti_image = $path;
        $this->transaction->save();

        session()->flash('success', 'Pembayaran berhasil dikonfirmasi.');
        return redirect()->route('history');
    }

    public function cancelTransaction()
    {
        try {
            $this->transaction->status = 'canceled';
            $this->transaction->save();

            session()->flash('success', 'Transaksi berhasil dibatalkan.');
            return redirect()->route('history');
        } catch (Throwable $e) {
            logger()->error('Error membatalkan transaksi: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat membatalkan transaksi.');
        }
    }

    public function render()
    {
        return view('livewire.user.booking.konfirmasi')
            ->extends('layouts.app')
            ->section('content');
    }
}
