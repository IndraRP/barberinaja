<?php

namespace App\Filament\Widgets;

use App\Models\Barber;
use App\Models\Service;
use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class MostChosenServicesWidget extends ChartWidget
{
    protected static ?string $heading = 'Barber Terpopuler';

    protected function getData(): array
    {
        $barberCounts = Transaction::select('barber_id', DB::raw('count(*) as count'))
                                          ->groupBy('barber_id')
                                          ->orderByDesc('count')
                                          ->get();

        // Memetakan data untuk chart
        $labels = $barberCounts->map(fn($item) => Barber::find($item->barber_id)->name)->toArray();
        $data = $barberCounts->map(fn($item) => $item->count)->toArray();

        // Menyiapkan data untuk chart
        return [
            'datasets' => [
                [
                    'label' => 'Barber Terpopuler',
                    'data' => $data,
                    'backgroundColor' => [ 
                        '#C40C0C',
                        '#FF8A08',
                        '#FF6500',                       
                        '#FFC100',
                    ],
                ],
            ],
            'labels' => $labels, 
        ];
    }


    protected function getType(): string
    {
        return 'polarArea';
    }
}
