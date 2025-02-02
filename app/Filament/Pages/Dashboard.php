<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\MonthTransactionWidget;
use App\Filament\Widgets\QuickAccessWidget;
use Filament\Facades\Filament;

class Dashboard extends \Filament\Pages\Dashboard
{
    public function getWidgets(): array
    {
        // Ambil semua widget yang terdaftar di Filament
        $widgets = Filament::getWidgets();

        // Periksa apakah QuickAccessWidget sudah ada dalam daftar widget
        if (($key = array_search(QuickAccessWidget::class, $widgets)) !== false) {
            // Jika ada, hapus QuickAccessWidget dari posisi semula
            unset($widgets[$key]);
        }

        // Periksa apakah QuickAccessWidget sudah ada dalam daftar widget
        if (($key = array_search(MonthTransactionWidget::class, $widgets)) !== false) {
            // Jika ada, hapus QuickAccessWidget dari posisi semula
            unset($widgets[$key]);
        }

        // Menambahkan QuickAccessWidget di posisi kedua
        array_splice($widgets, 1, 0, [QuickAccessWidget::class]);
        array_splice($widgets, 6, 0, [MonthTransactionWidget::class]);

        // Mengembalikan array widget setelah disesuaikan urutannya
        return $widgets;
    }
}
