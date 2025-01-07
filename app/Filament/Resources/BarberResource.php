<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarberResource\Pages;
use App\Models\Barber;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;

class BarberResource extends Resource
{
    protected static ?string $model = Barber::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Barber';
    protected static ?string $pluralLabel = 'Barbers';
    protected static ?string $navigationGroup = 'Barber';

    /**
     * Form untuk membuat dan mengedit barber.
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Barber')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('phone')
                    ->label('Nomor HP')
                    ->nullable(),

                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->nullable()
                    ->rows(3),

                FileUpload::make('image')
                    ->label('Gambar Profil')
                    ->image()
                    ->disk('public')
                    ->directory('images/barbers')
                    ->nullable()
                    ->rules('image', 'max:2048')
                    ->previewable(true),
            ]);
    }

    /**
     * Table untuk menampilkan daftar barbers.
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('name')->label('Nama Barber')->searchable(),
                TextColumn::make('email')->label('Email')->sortable(),
                TextColumn::make('phone')->label('Nomor HP'),
                TextColumn::make('description')->label('Deskripsi')->limit(50)->wrap(),

                ImageColumn::make('image')
                    ->label('Gambar Profil')
                    ->disk('public')
                    ->height(150),

                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    /**
     * Halaman CRUD untuk BarberResource.
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBarbers::route('/'),
            'create' => Pages\CreateBarber::route('/create'),
            'edit' => Pages\EditBarber::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [];
    }
}
