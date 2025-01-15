<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\PieChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WeeklyTransactionsWidget extends PieChartWidget
{
    protected static ?string $heading = 'Weekly Transactions Widget';

    protected function getData(): array
    {
        // Mendapatkan filter minggu, dengan default minggu saat ini
        $week = $this->filter['week'] ?? now()->weekOfMonth; // Default minggu ini
        $month = now()->format('m'); // Bulan sekarang
        $year = now()->year; // Tahun sekarang

        // Menghitung tanggal awal dan akhir minggu yang dipilih
        $startOfWeek = Carbon::now()->setISODate($year, $week)->startOfWeek();
        $endOfWeek = $startOfWeek->copy()->endOfWeek();

        // Query untuk mendapatkan total transaksi per hari dalam minggu yang dipilih
        $data = Transaction::select(
                DB::raw("DAYNAME(created_at) as day"),
                DB::raw('count(*) as total')
            )
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->groupBy('day')
            ->pluck('total', 'day')
            ->toArray();

        // Daftar hari dalam seminggu
        $days = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        // Menyusun data hari dengan memeriksa apakah ada data pada hari tersebut
        $labels = [];
        $values = [];
        foreach ($days as $key => $dayName) {
            $labels[] = $dayName;
            $values[] = $data[$key] ?? 0; // Jika tidak ada data, set ke 0
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Transaksi',
                    'data' => $values,
                    'backgroundColor' => [
                        '#453F78',
                        '#795458',
                        '#C08B5C',
                        '#FFC94A',
                        '#E48F45',
                        '#FF9F40',
                        '#FF6347',
                        '#FFBB70',
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getFilters(): ?array
    {
        // Filter untuk minggu ke-1 hingga ke-4
        $weeks = [
            1 => 'Minggu 1',
            2 => 'Minggu 2',
            3 => 'Minggu 3',
            4 => 'Minggu 4',
        ];

        return [
            'week' => [
                'label' => 'Minggu',
                'options' => $weeks,
            ],
        ];
    }
}
