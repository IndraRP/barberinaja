<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarberUsersResource\Pages;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class BarberUsersResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $pluralLabel = 'Barber User';
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'User';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique('users', 'email', fn($record) => $record),
                Forms\Components\TextInput::make('phone_number')
                    ->label('Nomor Handphone')
                    ->nullable()
                    ->maxLength(15)
                    ->tel()
                    ->placeholder('Masukkan nomor handphone'),
                Forms\Components\TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->dehydrateStateUsing(fn($state) => bcrypt($state))
                    ->required(fn($record) => $record === null),
                Forms\Components\Select::make('role')
                    ->label('Peran')
                    ->options([
                        'barber' => 'Barber ', // Hanya role customer yang bisa dipilih
                    ])
                    ->default('customer')
                    ->required(),
                FileUpload::make('image')
                    ->label('Gambar Profil')
                    ->image()
                    ->disk('public')
                    ->directory('images/profiles')
                    ->nullable()
                    ->rules('image', 'max:2048')
                    ->previewable(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('name')->label('Nama')->searchable(),
                TextColumn::make('email')->label('Email')->searchable(),
                TextColumn::make('phone_number')->label('Nomor Handphone')->searchable()->sortable(),
                BadgeColumn::make('role')
                    ->label('Peran')
                    ->color(function ($state) {
                        return match ($state) {
                            'owner' => 'success',
                            'barber' => 'warning',
                            'customer' => 'secondary',
                            default => 'gray',
                        };
                    }),
                TextColumn::make('created_at')->label('Dibuat Pada')->dateTime(),
                \Filament\Tables\Columns\ImageColumn::make('image')
                    ->label('Gambar Profil')
                    ->disk('public')
                    ->height(80)
                    ->width(80),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('Peran')
                    ->options([
                        'barber' => 'Barber',
                    ])
                    ->default('barber'), // Filter default untuk menampilkan hanya customer
            ])

            ->actions([])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListBarberUsers::route('/'),
            'create' => Pages\CreateBarberUsers::route('/create'),
            'edit' => Pages\EditBarberUsers::route('/{record}/edit'),
        ];
    }
}
