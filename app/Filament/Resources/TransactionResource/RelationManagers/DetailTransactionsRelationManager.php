<?php

namespace App\Filament\Resources\TransactionResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DetailTransactionsRelationManager extends RelationManager
{
    protected static string $relationship = 'details'; // Relasi ke DetailTransaction

    /**
     * Menampilkan tabel detail transaksi.
     */
    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('service.name')
                    ->label('Nama Layanan'),

                TextColumn::make('harga')
                    ->label('Harga')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.')),

                TextColumn::make('total_harga')
                    ->label('Total Harga')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.')),
            ]);
    }
}