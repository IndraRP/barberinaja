<?php

namespace App\Filament\Resources\DetailTransactionResource\Pages;

use App\Filament\Resources\DetailTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDetailTransactions extends ListRecords
{
    protected static string $resource = DetailTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
