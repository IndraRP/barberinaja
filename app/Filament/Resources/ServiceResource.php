<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
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

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationLabel = 'Layanan';
    protected static ?string $pluralLabel = 'Layanan';
    protected static ?string $navigationGroup = 'Isi Page';

    /**
     * Form untuk membuat dan mengedit service.
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Layanan')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(3)
                    ->nullable(),

                Forms\Components\TextInput::make('price')
                    ->label('Harga')
                    ->numeric()
                    ->required()
                    ->prefix('Rp'),

                // Menggunakan direktori yang sama dengan UserResource
                FileUpload::make('image')
                    ->label('Gambar Layanan')
                    ->image()
                    ->disk('public')
                    ->directory('images/services')
                    ->nullable()
                    ->rules('image', 'max:2048')
                    ->previewable(true),

                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'active' => 'Active',
                        'blocked' => 'Blocked',
                    ])
            ]);
    }

    /**
     * Table untuk menampilkan daftar services.
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('name')->label('Nama Layanan')->searchable(),
                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR'), // Format rupiah

                TextColumn::make('description')->label('Deskripsi')->limit(50)->wrap(),
                // Menampilkan gambar di tabel
                \Filament\Tables\Columns\ImageColumn::make('image')
                    ->label('Gambar Layanan')
                    ->disk('public')
                    ->height(80)
                    ->width(80),

                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->getStateUsing(function ($record) {
                        return [
                            'active' => 'Active',
                            'blocked' => 'Blocked',
                        ][$record->status] ?? 'Unknown';
                    }),


            ])
            ->actions([
                EditAction::make()
                    ->icon('heroicon-o-pencil-square')
                    ->label(''),

                DeleteAction::make()
                    ->icon('heroicon-o-trash')
                    ->label(''),
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
            ]);
    }

    /**
     * Halaman CRUD untuk ServiceResource.
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [];
    }
}
