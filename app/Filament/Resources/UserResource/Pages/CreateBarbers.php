<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBarber extends CreateRecord
{
    protected static string $resource = UserResource::class;

    // Form untuk Create Barber
    protected function getFormSchema(): array
    {
        return [
            // Menambahkan kolom form yang spesifik untuk barber
            \Filament\Forms\Components\TextInput::make('name')
                ->label('Nama')
                ->required()
                ->maxLength(255),
            \Filament\Forms\Components\TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->unique('users', 'email'),
            \Filament\Forms\Components\TextInput::make('phone_number')
                ->label('Nomor Handphone')
                ->nullable()
                ->maxLength(15)
                ->tel()
                ->placeholder('Masukkan nomor handphone'),
            \Filament\Forms\Components\TextInput::make('password')
                ->label('Password')
                ->password()
                ->required(),
            \Filament\Forms\Components\Select::make('role')
                ->label('Peran')
                ->default('barber')
                ->disabled(),
            \Filament\Forms\Components\FileUpload::make('image')
                ->label('Gambar Profil')
                ->image()
                ->disk('public')
                ->directory('images/profiles')
                ->nullable()
                ->rules('image', 'max:2048')
                ->previewable(true),
        ];
    }
}
