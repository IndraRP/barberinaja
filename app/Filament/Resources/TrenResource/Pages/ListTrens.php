<?php

namespace App\Filament\Resources\TrenResource\Pages;

use App\Filament\Resources\TrenResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrens extends ListRecords
{
    protected static string $resource = TrenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
