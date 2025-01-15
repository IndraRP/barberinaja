<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use App\Models\DetailTransaction;
use Filament\Widgets\ChartWidget;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Pendapatan';

    protected function getData(): array
    {
        // Ambil filter dari permintaan pengguna
        $startDate = $this->getStartDate();
        $endDate = $this->getEndDate();
        $status = $this->getStatus();
        $paymentMethod = $this->getPaymentMethod();

        // Ambil data pendapatan
        $revenue = $this->getRevenueData($startDate, $endDate, $status, $paymentMethod);

        $labels = $revenue->pluck('label');
        $amounts = $revenue->pluck('total_revenue');

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Pendapatan',
                    'data' => $amounts,
                    'backgroundColor' => '#a48118b5',
                    'borderColor' => '#ffbf00',
                    'borderWidth' => 2,
                    'fill' => true,
                ]
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line'; 
    }

    private function getRevenueData($startDate, $endDate, $status, $paymentMethod)
    {
        $query = DB::table('transactions')
            ->join('detail_transactions', 'transactions.id', '=', 'detail_transactions.transactions_id')
            ->select(
                DB::raw('DATE(transactions.created_at) as label'),
                DB::raw('SUM(detail_transactions.total_harga) as total_revenue')
            )
            ->whereBetween('transactions.created_at', [$startDate, $endDate]);

        if ($status) {
            $query->where('transactions.status', $status);
        }

        return $query->groupBy(DB::raw('DATE(transactions.created_at)'))
            ->orderBy('label', 'asc')
            ->get();
    }

    private function getStartDate()
    {
        return $this->state['start_date'] ?? Carbon::now()->startOfYear(); 
    }

    private function getEndDate()
    {
        return $this->state['end_date'] ?? Carbon::now(); 
    }

    private function getStatus()
    {
        return $this->state['status'] ?? null;
    }

    private function getPaymentMethod()
    {
        return $this->state['payment_method'] ?? null; 
    }

    public function filters()
    {
        return [
            DatePicker::make('start_date')
                ->label('Tanggal Mulai')
                ->default(Carbon::now()->startOfYear())
                ->reactive()
                ->afterStateUpdated(function () {
                    $this->emit('refreshChart');
                }),

            DatePicker::make('end_date')
                ->label('Tanggal Akhir')
                ->default(Carbon::now())
                ->reactive()
                ->afterStateUpdated(function () {
                    $this->emit('refreshChart');
                }),

            Select::make('status')
                ->label('Status Transaksi')
                ->options([
                    'pending' => 'Pending',
                    'approved' => 'Approved',
                    'completed' => 'Completed',
                    'canceled' => 'Canceled',
                ])
                ->reactive()
                ->afterStateUpdated(function () {
                    $this->emit('refreshChart');
                })
                ->reactive()
                ->afterStateUpdated(function () {
                    $this->emit('refreshChart');
                }),
        ];
    }
}
