<?php

namespace App\Livewire\User\Booking;

use Livewire\Component;
use App\Models\Transaction;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use Throwable;

class Konfirmasi extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $transaction;
    public $bukti_image;

    protected $messages = [
        'bukti_image.required' => 'File bukti pembayaran wajib diupload.',
        'bukti_image.image' => 'File harus berupa gambar. Gunakan jpeg, png, jpg, gif, svg, atau webp. ',
        'bukti_image.mimes' => 'Format gambar tidak didukung. Gunakan jpeg, png, jpg, gif, svg, atau webp.',
        'bukti_image.max' => 'Ukuran file maksimum adalah 5MB.',
    ];


    protected $rules = [
        'bukti_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp,JPG,HEIC|max:5120',
    ];

    public function mount($transactionId)
    {
        $this->transaction = Transaction::find($transactionId);

        if (!$this->transaction) {
            abort(404, 'Transaksi tidak ditemukan');
        }
    }

    public function showAlert()
    {
        $this->alert('success', 'Berhasil!', [
            'text' => 'No. Rekening berhasil disalin'
        ]);
    }

    public function updatedBuktiImage()
    {
        try {
            $this->validate([
                'bukti_image' => 'image|max:2048', // Maksimal 2MB
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->reset('bukti_image'); // Reset input jika gagal validasi
            throw $e;
        }
    }

    public function confirmPayment()
    {
        $this->validate();
        if (!$this->bukti_image) {
            logger()->error('File tidak ditemukan saat validasi.');
            $this->alert('error', 'Harap upload file sebelum mengonfirmasi pembayaran.');
            return;
        }


        $path = $this->bukti_image->store('images/bukti_transaksi', 'public');

        $this->transaction->bukti_image = $path;
        $this->transaction->save();

        $this->alert('success', 'Konfirmasi berhasil dilakukan.');
        return redirect()->route('history');
    }

    // public function cancelTransaction()
    // {
    //     try {
    //         $this->transaction->status = 'canceled';
    //         $this->transaction->save();

    //         session()->flash('success', 'Transaksi berhasil dibatalkan.');
    //         return redirect()->route('history');
    //     } catch (Throwable $e) {
    //         logger()->error('Error membatalkan transaksi: ' . $e->getMessage());
    //         session()->flash('error', 'Terjadi kesalahan saat membatalkan transaksi.');
    //     }
    // }

    public function render()
    {
        return view('livewire.user.booking.konfirmasi')
            ->extends('layouts.app')
            ->section('content');
    }
}
