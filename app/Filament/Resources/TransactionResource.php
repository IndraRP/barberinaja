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
                        'arrived' => 'Datang',
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

                TextColumn::make('details.service.name')
                    ->label('Nama Layanan')
                    ->sortable(),

                TextColumn::make('phone_number')
                    ->label('Phone Number')
                    ->sortable(),

                ImageColumn::make('bukti_image')
                    ->label('Bukti Transaksi')
                    ->url(fn($record) => asset('storage/' . $record->bukti_image), true) // true untuk membuka di tab baru
                    ->disk('public')
                    ->height(100)
                    ->width(80),

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

                TextColumn::make('created_at')
                    ->label('Jam Pesan')
                    ->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'completed' => 'Completed',
                        'arrived' => 'Arrived',
                        'canceled' => 'Canceled',
                    ])
                    ->default('pending'), // Set default filter ke 'pending'

            ])
            ->modifyQueryUsing(function ($query) {
                $status = request()->input('filters.status');

                if ($status === 'pending') {
                    return $query->where('status', 'pending')
                        ->whereNotNull('bukti_image');
                }

                // Jika status ada, tambahkan kondisi untuk status tersebut
                if ($status) {
                    return $query->where('status', $status);
                }

                return $query->where('status', 'pending')
                    ->whereNotNull('bukti_image');
            })


            // EditAction::make()
            //     ->icon('heroicon-o-pencil-square')
            //     ->label(''),

            // DeleteAction::make()
            //     ->icon('heroicon-o-trash')
            //     ->label(''), // Menghapus label agar hanya ikon yang ditampilkan

            ->actions([
                Action::make('approve')
                    ->label('Approve')
                    ->action(function ($record) {
                        if ($record->status === 'pending') {
                            $record->update([
                                'status' => 'approved',
                            ]);

                            DB::table('barber_schedules')->insert([
                                'barber_id' => $record->barber_id,
                                'transaction_id' => $record->id,
                                'day' => $record->appointment_date,
                                'start_time' => $record->time,
                                'end_time' => \Carbon\Carbon::parse($record->time)->addMinutes(30)->format('H:i:s'),
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);

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
            ->actions([
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
                                ->title('Transaksi Disetujui!')
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Transaksi tidak dapat disetujui.')
                                ->danger()
                                ->send();
                        }
                    })
                    ->icon('heroicon-o-check')
                    ->requiresConfirmation()
                    ->color('success'),

                Action::make('cancel')
                    ->label('Cancel')
                    ->action(function ($record) {
                        if ($record->status !== 'canceled') {
                            $record->update([
                                'status' => 'canceled',
                                'canceled' => 'payment',
                            ]);

                            Notification::make()
                                ->title('Transaksi Dibatalkan!')
                                ->danger()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Transaksi sudah dibatalkan sebelumnya.')
                                ->warning()
                                ->send();
                        }
                    })
                    ->icon('heroicon-o-x-circle')
                    ->requiresConfirmation()
                    ->color('danger'),
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
            ]);

        // ->modifyQueryUsing(function ($query) {
        //     if (request()->has('filters.status') && request()->input('filters.status') !== null) {
        //         $query->where('status', request()->input('filters.status'));
        //     } else {
        //         $query->where('status', 'pending'); // Hanya jika filter status belum dipilih
        //     }

        //     return $query->whereNotNull('bukti_image')->latest();
        // });
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
            // 'create' => Pages\CreateTransaction::route('/create'),
            // 'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
