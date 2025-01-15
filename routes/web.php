<?php

use App\Livewire\Auth\Forgotpassword\Forgotpassword;
use App\Livewire\Auth\Login\AuthLoginIndex as LoginAuthLoginIndex;
use App\Livewire\Auth\Resetpassword\Resetpassword;
use App\Livewire\Auth\Signup\Signup;
use App\Livewire\Barber\Booking\Layanan;
use App\Livewire\Barber\History\Riwayat as HistoryRiwayat;
use App\Livewire\Barber\Home\Homepage;
use App\Livewire\Barber\Home\Profile;
use App\Livewire\Barber\Home\Trendetail as HomeTrendetail;
use App\Livewire\User\Barber\Barberdetail;
use App\Livewire\User\Booking\Bookingdetail;
use App\Livewire\User\Booking\Bookingdetail2;
use App\Livewire\User\Booking\Form;
use App\Livewire\User\Booking\Konfirmasi;
use App\Livewire\User\Booking\Metodepembayaran;
use App\Livewire\User\History\DetailRiwayat;
use App\Livewire\User\History\Riwayat;
use App\Livewire\User\Home\UserHomeIndex;
use Illuminate\Support\Facades\Hash;

use App\Livewire\User\Home\Trendetail;
use App\Livewire\User\Profile\Profil;
use Illuminate\Support\Facades\Route;

Route::get('/cek', function () {
    dd(Hash::make('12345678'));
    return view('welcome');
});

Route::get('/login', LoginAuthLoginIndex::class)->name('login');
Route::get('/sign_up', Signup::class)->name('signup');
Route::get('/forgot-password', Forgotpassword::class)->name('forgot-password');
Route::get('/reset-password/{token}/{email}', Resetpassword::class)->name('password.reset');


Route::get('/barber', function () {
    return view('barber');
});

Route::group(['namespace' => 'App\Livewire'], function () {
    // Route::group(['namespace' => 'Auth'], function () {
    //     Route::get('/login', Login\AuthLoginIndex::class)->name('login');
    // });
    Route::group(['namespace' => 'User'], function () {
        Route::get('/', UserHomeIndex::class)->name('home');

        Route::get('/booking', Bookingdetail::class)->name('booking');
        Route::get('/bookingdetail/{serviceId}', Bookingdetail2::class)->name('bookingdetail');
        Route::get('/form/{id}', Form::class)->name('form');
        Route::get('/metodepembayaran', Metodepembayaran::class)->name('metodepembayaran');
        Route::get('/konfirmasi/{transactionId}', Konfirmasi::class)->name('konfirmasi');

        Route::get('/barberdetail/{id}', Barberdetail::class)->name('barberdetail');
        Route::get('/trendetail/{id}', Trendetail::class)->name('trendetail');

        Route::get('/riwayat', Riwayat::class)->name('history');
        Route::get('/detail_riwayat/{id}', DetailRiwayat::class)->name('history_detail');

        Route::get('/profile', Profil::class)->name('profile');
    });

    Route::group(['namespace' => 'Barber', 'middleware' => ['role:barber']], function () {
        Route::get('/home_barber', Homepage::class)->name('home_barber');
        Route::get('/layanan_barber', Layanan::class)->name('layanan_barber');
        Route::get('/tren_detail_barber/{id}', HomeTrendetail::class)->name('tren_detail_barber');
        Route::get('/history_barber', HistoryRiwayat::class)->name('history_barber');
        Route::get('/profile_barber', Profile::class)->name('profile_barber');
    });
});
