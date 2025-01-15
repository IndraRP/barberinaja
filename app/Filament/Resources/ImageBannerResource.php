<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ImageBannerResource\Pages;
use App\Models\ImageBanner;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table as TablesTable;

class ImageBannerResource extends Resource
{
    protected static ?string $model = ImageBanner::class;
    protected static ?string $navigationGroup = 'Isi Page';
    protected static ?string $pluralLabel = 'Foto Banner';
    protected static ?string $navigationIcon = 'heroicon-o-photo';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                FileUpload::make('image')
                    ->label('Gambar Profil')
                    ->image()
                    ->disk('public')
                    ->directory('images/banner')
                    ->nullable()
                    ->rules('image', 'max:2048')
                    ->previewable(true),

                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'active' => 'Active',
                        'blocked' => 'Blocked',
                    ])
                    ->default('active')
                    ->required(),
            ]);
    }

    public static function table(TablesTable $table): TablesTable
    {
        return $table
            ->columns([
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListImageBanners::route('/'),
            'create' => Pages\CreateImageBanner::route('/create'),
            'edit' => Pages\EditImageBanner::route('/{record}/edit'),
        ];
    }
}
