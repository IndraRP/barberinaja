<?php

namespace App\Filament\Resources\DetailTransactionResource\Pages;

use App\Filament\Resources\DetailTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDetailTransaction extends EditRecord
{
    protected static string $resource = DetailTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
