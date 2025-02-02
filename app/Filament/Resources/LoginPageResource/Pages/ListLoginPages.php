<?php

namespace App\Filament\Resources\LoginPageResource\Pages;

use App\Filament\Resources\LoginPageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLoginPages extends ListRecords
{
    protected static string $resource = LoginPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
