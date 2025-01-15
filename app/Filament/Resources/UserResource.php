<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Forms\Components\FileUpload;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $pluralLabel = 'Customer User';
    protected static ?string $navigationGroup = 'User';

    // Form untuk create dan edit
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
                        'customer' => 'Customer', // Hanya role customer yang bisa dipilih
                    ])
                    ->default('customer')
                    ->required(),
                // FileUpload::make('image')
                //     ->label('Gambar Profil')
                //     ->image()
                //     ->disk('public')
                //     ->directory('images/profiles')
                //     ->nullable()
                //     ->rules('image', 'max:2048')
                //     ->previewable(true),
            ]);
    }

    // Table untuk menampilkan data pengguna
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
                        'customer' => 'Customer',
                    ])
                    ->default('customer'),
            ])
            ->actions([
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }


    public static function getRelations(): array
    {
        return [
            // Tambahkan relasi jika diperlukan
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
