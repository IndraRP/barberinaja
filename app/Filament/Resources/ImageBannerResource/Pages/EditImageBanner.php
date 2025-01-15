<?php

namespace App\Filament\Resources\ImageBannerResource\Pages;

use App\Filament\Resources\ImageBannerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditImageBanner extends EditRecord
{
    protected static string $resource = ImageBannerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
