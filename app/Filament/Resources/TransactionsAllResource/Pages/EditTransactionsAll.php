<?php

namespace App\Filament\Resources\TransactionsAllResource\Pages;

use App\Filament\Resources\TransactionsAllResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTransactionsAll extends EditRecord
{
    protected static string $resource = TransactionsAllResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
