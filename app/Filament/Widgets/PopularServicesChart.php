<?php

namespace App\Filament\Widgets;

use App\Models\DetailTransaction;
use Filament\Widgets\ChartWidget;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\DB;

class PopularServicesChart extends ChartWidget
{
    protected static ?string $heading = 'Layanan Terpopuler';

    protected function getData(): array
    {
        // Ambil filter dari permintaan pengguna
        $startDate = $this->getStartDate();
        $endDate = $this->getEndDate();

        // Ambil data layanan terpopuler
        $services = $this->getPopularServices($startDate, $endDate);

        $labels = $services->pluck('service_name');
        $counts = $services->pluck('total');

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Layanan Terpopuler',
                    'data' => $counts,
                    'backgroundColor' => [
                        '#FABC3F',
                        '#E85C0D',
                        '#973131',
                        '#C7253E',
                        '#FFEC9E',
                        '#FFBB70',
                        '#FF6347'
                    ],  // Warna untuk setiap bagian donut chart
                    'borderColor' => '#fff',  // Warna border
                    'borderWidth' => 1,
                ]
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';  // Menggunakan doughnut chart
    }

    private function getPopularServices($startDate, $endDate)
    {
        // Query untuk mengambil layanan yang terpopuler dalam rentang tanggal tertentu
        return DB::table('detail_transactions')
            ->join('services', 'detail_transactions.service_id', '=', 'services.id')
            ->select('services.name as service_name', DB::raw('count(*) as total'))
            ->whereBetween('detail_transactions.created_at', [$startDate, $endDate])
            ->groupBy('detail_transactions.service_id')
            ->orderByDesc('total')
            ->get();
    }

    private function getStartDate()
    {
        return $this->state['start_date'] ?? now()->startOfYear();  // Default ke awal tahun
    }

    private function getEndDate()
    {
        return $this->state['end_date'] ?? now();  // Default ke hari ini
    }

    public function filters()
    {
        return [
            Select::make('start_date')
                ->label('Tanggal Mulai')
                ->default(now()->startOfYear())
                ->reactive()
                ->afterStateUpdated(function () {
                    $this->emit('refreshChart');
                }),

            Select::make('end_date')
                ->label('Tanggal Akhir')
                ->default(now())
                ->reactive()
                ->afterStateUpdated(function () {
                    $this->emit('refreshChart');
                }),
        ];
    }
}
