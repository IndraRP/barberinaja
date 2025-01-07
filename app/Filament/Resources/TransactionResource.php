<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers\DetailTransactionsRelationManager;
use App\Models\Transaction;
use App\Models\BarberSchedule;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Transaksi';
    protected static ?string $pluralLabel = 'Transaksi';
    protected static ?string $navigationGroup = 'Transaksi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name_customer')
                    ->label('Customer Name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('phone_number')
                    ->label('Phone Number')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TimePicker::make('time')
                    ->label('Jam Dilayani')
                    ->required(),

                FileUpload::make('bukti_image')
                    ->label('Bukti Pembayaran')
                    ->image()
                    ->disk('public')
                    ->directory('images/bukti_transaksi')
                    ->nullable()
                    ->rules(['image', 'max:2048'])
                    ->previewable(true),

                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Menunggu Konfirmasi',
                        'approved' => 'Menunggu Hari',
                        'completed' => 'Selesai',
                        'canceled' => 'Dibatalkan',
                    ])
                    ->default('pending')
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('name_customer')
                    ->label('Customer Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('phone_number')
                    ->label('Phone Number')
                    ->sortable(),

                ImageColumn::make('bukti_image')
                    ->label('Bukti Transaksi')
                    ->disk('public')
                    ->height(100),

                TextColumn::make('barber.name')
                    ->label('Barber Name')
                    ->sortable(),

                TextColumn::make('details.total_harga')
                    ->label('Total Harga')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->getStateUsing(function ($record) {
                        return [
                            'pending' => 'Pending',
                            'approved' => 'Approved',
                            'completed' => 'Completed',
                            'canceled' => 'Canceled',
                        ][$record->status] ?? 'Unknown';
                    }),

                TextColumn::make('time')
                    ->label('Jam Dilayani')
                    ->sortable(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
                Action::make('approve')
                    ->label('Approve')
                    ->action(function ($record) {
                        if ($record->status === 'pending') {
                            // Ubah status transaksi menjadi approved
                            $record->update([
                                'status' => 'approved',
                            ]);

                            // Simpan jadwal barber ke tabel barber_schedules
                            DB::table('barber_schedules')->insert([
                                'barber_id' => $record->barber_id,
                                'transaction_id' => $record->id,
                                'day' => $record->appointment_date, // Tanggal dari transaksi
                                'start_time' => $record->time, // Waktu mulai dari transaksi
                                'end_time' => \Carbon\Carbon::parse($record->time)->addMinutes(30)->format('H:i:s'),
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);

                            // Kirim notifikasi bahwa transaksi telah disetujui
                            Notification::make()
                                ->title('Transaction Approved!')
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Transaction cannot be approved.')
                                ->danger()
                                ->send();
                        }
                    })
                    ->icon('heroicon-o-check')
                    ->requiresConfirmation()
                    ->color('success'),
            ])
            ->bulkActions([
                BulkAction::make('delete_selected')
                    ->label('Delete Selected')
                    ->action(function ($records) {
                        foreach ($records as $record) {
                            $record->delete();
                        }

                        Notification::make()
                            ->title('Records Deleted')
                            ->body('Selected transactions have been deleted successfully.')
                            ->success()
                            ->send();
                    })
                    ->icon('heroicon-o-trash'),
            ])->modifyQueryUsing(fn ($query) => $query->latest());
    }

    public static function getRelations(): array
    {
        return [
            DetailTransactionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
