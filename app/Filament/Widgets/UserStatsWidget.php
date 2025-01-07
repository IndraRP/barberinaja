<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\User;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\DetailTransaction;
use App\Models\Tren;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserStatsWidget extends ChartWidget
{
    protected static ?string $heading = 'Statistik Dasbor';

    protected function getData(): array
    {
        $totalUsers = User::count();  // Jumlah user
        $totalServices = Service::count();  // Jumlah service
        $totalTransactionsToday = Transaction::whereDate('created_at', Carbon::today())->count();  // Jumlah transaksi hari ini
        $totalTren = Tren::count();  // Jumlah service

        // Mendapatkan service yang paling banyak dipilih
        $mostChosenService = DetailTransaction::select('service_id', DB::raw('count(*) as count'))
                                               ->groupBy('service_id')
                                               ->orderByDesc('count')
                                               ->limit(1)
                                               ->first();

        // Menyiapkan data untuk chart
        return [
            'datasets' => [
                [
                    'label' => 'Total Stats',
                    'data' => [
                        $totalUsers,  // Data jumlah user
                        $totalServices,  // Data jumlah services
                        $totalTransactionsToday,  // Data jumlah transaksi hari ini
                        $totalTren,  // Data jumlah berita (sesuaikan jika ada)
                    ],
                    'backgroundColor' => ['#4CAF50', '#2196F3', '#FF9800', '#9C27B0'],
                ],
            ],
            'labels' => ['Users', 'Services', 'Transactions Today', 'Tren'], // Label untuk chart
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // Anda bisa mengganti jenis chart sesuai kebutuhan, seperti 'line' atau 'pie'
    }
}
