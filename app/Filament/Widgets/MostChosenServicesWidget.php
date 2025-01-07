<?php

namespace App\Filament\Widgets;

use App\Models\DetailTransaction;
use App\Models\Service;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class MostChosenServicesWidget extends ChartWidget
{
    protected static ?string $heading = 'Layanan Terpopuler';

    protected function getData(): array
    {
        // Menghitung jumlah pemilihan setiap service berdasarkan detail transaksi
        $serviceCounts = DetailTransaction::select('service_id', DB::raw('count(*) as count'))
                                          ->groupBy('service_id')
                                          ->orderByDesc('count')
                                          ->get();

        // Memetakan data untuk chart
        $labels = $serviceCounts->map(fn($item) => Service::find($item->service_id)->name)->toArray();
        $data = $serviceCounts->map(fn($item) => $item->count)->toArray();

        // Menyiapkan data untuk chart
        return [
            'datasets' => [
                [
                    'label' => 'Most Chosen Services',
                    'data' => $data,
                    'backgroundColor' => '#4CAF50',  // Ganti dengan warna yang diinginkan
                ],
            ],
            'labels' => $labels,  // Menampilkan nama service pada label
        ];
    }


    protected function getType(): string
    {
        return 'polarArea';
    }
}
