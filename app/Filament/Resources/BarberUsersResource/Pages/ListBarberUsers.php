<?php

namespace App\Filament\Resources\BarberUsersResource\Pages;

use App\Filament\Resources\BarberUsersResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBarberUsers extends ListRecords
{
    protected static string $resource = BarberUsersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
