<?php

namespace App\Filament\Widgets;

use App\Models\Service;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Barber;
use App\Models\DetailTransaction;
use App\Models\ImageBanner;
use App\Models\Tren;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Carbon\Carbon;

class DashboardStatsWidget extends BaseWidget
{
    protected ?string $heading = 'Dashboard Stats';

    protected function getCards(): array
    {
        return [
            Card::make('Pendapatan Hari Ini', 'Rp ' . number_format(
                DetailTransaction::whereHas('transaction', function ($query) {
                    $query->whereDate('created_at', Carbon::today())
                        ->whereNotNull('bukti_image');
                })->sum('total_harga'),
                0,
                ',',
                '.'
            ))
                ->description('Total pendapatan dari transaksi hari ini')
                ->icon('heroicon-o-currency-dollar'),

            Card::make('Transaksi belum Approve', Transaction::where('status', 'pending')->whereNotNull('bukti_image')->count())
                ->description('Jumlah Transaksi yang belum anda Approve')
                ->icon('heroicon-o-archive-box-arrow-down')
                ->url('/admin/transactions', true),

            Card::make('Jumlah Layanan', Service::count())
                ->description('Total layanan yang tersedia')
                ->icon('heroicon-o-rectangle-stack'),

            Card::make('Jumlah Customer', User::where('role', 'customer')->count())
                ->description('Total pelanggan yang terdaftar')
                ->icon('heroicon-o-users'),

            Card::make('Transaksi Hari Ini', Transaction::whereDate('created_at', Carbon::today())
                ->whereNotNull('bukti_image')
                ->count())
                ->description('Jumlah transaksi yang terjadi hari ini')
                ->icon('heroicon-o-banknotes'),


            Card::make('Jumlah Barber', Barber::count())
                ->description('Total barber yang tersedia')
                ->icon('heroicon-o-user-group'),
        ];
    }
}
