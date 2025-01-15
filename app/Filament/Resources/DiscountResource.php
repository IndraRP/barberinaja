<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DiscountResource\Pages;
use App\Filament\Resources\DiscountResource\RelationManagers;
use App\Models\Discount;
use App\Models\Service;

use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;

use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DiscountResource extends Resource
{
    protected static ?string $model = Discount::class;

    protected static ?string $navigationIcon = 'heroicon-o-percent-badge';
    protected static ?string $navigationLabel = 'Discount';
    protected static ?string $pluralLabel = 'Discount';
    protected static ?string $navigationGroup = 'Isi Page';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Judul Discount')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->nullable()
                    ->rows(3),

                FileUpload::make('image')
                    ->label('Gambar Icon Diskon')
                    ->image()
                    ->disk('public')
                    ->directory('images/discount')
                    ->nullable()
                    ->rules('image', 'max:2048')
                    ->previewable(true),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'active' => 'Active',
                        'blocked' => 'Blocked',
                    ])
                    ->default('active'),
                Forms\Components\TextInput::make('discount_percentage')
                    ->label('Discount Percentage')
                    ->numeric()
                    ->required(),
                Forms\Components\Select::make('service_id')
                    ->label('Service')
                    ->options(Service::all()->pluck('name', 'id'))
                    ->searchable()
                    ->nullable(),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nama Discount')->searchable(),
                TextColumn::make('description')->label('Deskripsi Discount')->searchable(),
                TextColumn::make('description')->label('Deskripsi Discount')->searchable(),
                TextColumn::make('service.name')
                    ->label('Nama Layanan')
                    ->sortable(),

                TextColumn::make('discount_percentage')
                    ->label('Persentase Discount')
                    ->searchable()
                    ->formatStateUsing(fn($record, $column, $state) => $state . '%'),


                ImageColumn::make('image')
                    ->label('Gambar Profil')
                    ->disk('public')
                    ->height(80)
                    ->width(100),
                TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->getStateUsing(function ($record) {
                        return [
                            'active' => 'Active',
                            'blocked' => 'Blocked',
                        ][$record->status] ?? 'Unknown';
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make()
                    ->icon('heroicon-o-pencil-square')
                    ->label(''),

                DeleteAction::make()
                    ->icon('heroicon-o-trash')
                    ->label(''),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDiscounts::route('/'),
            'create' => Pages\CreateDiscount::route('/create'),
            'edit' => Pages\EditDiscount::route('/{record}/edit'),
        ];
    }
}
