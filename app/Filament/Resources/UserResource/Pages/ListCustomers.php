<?php
namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Filters\SelectFilter;

class ListCustomers extends ListRecords
{
    protected static string $resource = UserResource::class;

    // Menambahkan filter untuk tabel
    public function getTableFilters(): array
    {
        return [
            SelectFilter::make('role')
                ->label('Peran')
                ->options([
                    'barber' => 'Barber',
                    'customer' => 'Customer',
                ])
                ->default('customer')
        ];
    }
}
