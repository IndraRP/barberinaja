<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\EditRecord;

class EditBarber extends EditRecord
{
    protected static string $resource = UserResource::class;

    // Form untuk Edit Barber
    protected function getFormSchema(): array
    {
        return [
            \Filament\Forms\Components\TextInput::make('name')
                ->label('Nama')
                ->required()
                ->maxLength(255),
            \Filament\Forms\Components\TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->unique('users', 'email', fn($record) => $record),
            \Filament\Forms\Components\TextInput::make('phone_number')
                ->label('Nomor Handphone')
                ->nullable()
                ->maxLength(15)
                ->tel()
                ->placeholder('Masukkan nomor handphone'),
            \Filament\Forms\Components\TextInput::make('password')
                ->label('Password')
                ->password()
                ->dehydrateStateUsing(fn($state) => bcrypt($state))
                ->nullable(),
            \Filament\Forms\Components\Select::make('role')
                ->label('Peran')
                ->default('barber')
                ->disabled(), // Tidak bisa mengubah role
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
