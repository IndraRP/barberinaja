<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrenResource\Pages;
use App\Models\Tren;
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

class TrenResource extends Resource
{
    protected static ?string $model = Tren::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationLabel = 'Tren';
    protected static ?string $pluralLabel = 'Tren';
    protected static ?string $navigationGroup = 'Isi Page';

    /**
     * Form untuk membuat dan mengedit tren.
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Tren')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->nullable()
                    ->rows(3),

                FileUpload::make('image')
                    ->label('Gambar Tren')
                    ->image()
                    ->disk('public')
                    ->directory('images/tren')
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
     * Table untuk menampilkan daftar tren.
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('name')->label('Nama Tren')->searchable(),
                TextColumn::make('description')->label('Deskripsi')->limit(50)->wrap(),

                ImageColumn::make('image')
                    ->label('Gambar Tren')
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
            ]);
    }

    /**
     * Halaman CRUD untuk TrenResource.
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrens::route('/'),
            'create' => Pages\CreateTren::route('/create'),
            'edit' => Pages\EditTren::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [];
    }
}
