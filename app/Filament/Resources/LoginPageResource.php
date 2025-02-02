<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LoginPageResource\Pages;
use App\Models\LoginPage;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class LoginPageResource extends Resource
{
    protected static ?string $model = LoginPage::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Isi Page';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->label('Title')
                ->required()
                ->maxLength(255),

            FileUpload::make('image')
                ->label('Foto')
                ->image()
                ->disk('public')
                ->directory('images/login')
                ->nullable()
                ->rules('image', 'max:2048')
                ->previewable(true),

        ]);
    }

    // Table untuk menampilkan data di halaman index
    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('title')
                ->label('Title')
                ->sortable()
                ->searchable(),

            ImageColumn::make('image')
                ->label('Gambar Profil')
                ->disk('public')
                ->height(80)
        ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListLoginPages::route('/'),
            'create' => Pages\CreateLoginPage::route('/create'),
            'edit' => Pages\EditLoginPage::route('/{record}/edit'),
        ];
    }
}
