<?php

namespace App\Filament\Resources\TrenResource\Pages;

use App\Filament\Resources\TrenResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTren extends EditRecord
{
    protected static string $resource = TrenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
