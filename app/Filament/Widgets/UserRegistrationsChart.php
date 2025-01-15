<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Filament\Widgets\BarChartWidget;

class UserRegistrationsChart extends BarChartWidget
{
    protected static ?string $heading = 'Jumlah Pendaftaran Pengguna';

    // Menambahkan filter ke dalam getFilters method
    protected function getFilters(): ?array
    {
        $years = [];
        $current_year = now()->year;
        for ($i = $current_year; $i >= ($current_year - 10); $i--) {
            $years[$i] = $i; // Kunci dan nilai sama
        }
    
        return $years;
    }

    protected function getData(): array
    {
        // Mendapatkan nilai filter 'tahun'
        $year = $this->filter ?? Carbon::now()->year;

        // Query untuk data pendaftaran pengguna per bulan
        $registrations = User::select(DB::raw('MONTH(created_at) as label'), DB::raw('count(*) as total'))
            ->whereYear('created_at', $year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('label', 'asc')
            ->get()
            ->map(function ($item) {
                // Mengubah label bulan dari angka menjadi nama bulan
                $item->label = Carbon::createFromFormat('m', $item->label)->format('F');
                return $item;
            });

        // Daftar bulan
        $months = collect([
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ]);

        // Menyusun data bulan dengan memeriksa apakah ada data pada bulan tersebut
        $allMonthsData = $months->map(function ($month) use ($registrations) {
            $data = $registrations->firstWhere('label', $month);
            return $data ?: (object) ['label' => $month, 'total' => 0];
        });

        $labels = $allMonthsData->pluck('label');
        $counts = $allMonthsData->pluck('total');

        // Mengembalikan data untuk ditampilkan di chart
        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Pendaftaran Pengguna',
                    'data' => $counts,
                    'backgroundColor' => [
                        '#FABC3F', '#E85C0D', '#973131', '#C7253E', '#FFEC9E', '#FFBB70', '#FF6347'
                    ],
                    'borderColor' => '#388E3C',
                    'borderWidth' => 1,
                ]
            ],
        ];
    }
}
