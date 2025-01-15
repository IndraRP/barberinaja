<?php

namespace App\Filament\Resources\BarberUsersResource\Pages;

use App\Filament\Resources\BarberUsersResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBarberUsers extends EditRecord
{
    protected static string $resource = BarberUsersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
