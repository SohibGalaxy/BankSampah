<?php

namespace App\Filament\Resources;

use App\Models\Transaksi;
use App\Models\JenisSampah;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\TransaksiResource\Pages;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('id_nasabah')
                ->label('Nasabah')
                ->relationship('nasabah', 'nama')
                ->searchable()
                ->required(),

            Radio::make('jenis_transaksi')
                ->label('Jenis Transaksi')
                ->options([
                    'masuk' => 'Pemasukan (Sampah Masuk)',
                    'keluar' => 'Pengeluaran (Penarikan Saldo)',
                ])
                ->required()
                ->inline()
                ->reactive(),

            Select::make('id_jenis')
                ->label('Jenis Sampah')
                ->relationship('jenisSampah', 'nama')
                ->searchable()
                ->visible(fn ($get) => $get('jenis_transaksi') === 'masuk')
                ->requiredIf('jenis_transaksi', 'masuk')
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {
                    if ($state) {
                        $harga = JenisSampah::find($state)?->harga_per_kg ?? 0;
                        $set('harga_per_kg', $harga);
                    }
                }),

            TextInput::make('harga_per_kg')
                ->label('Harga per Kg')
                ->numeric()
                ->readOnly()
                ->visible(fn ($get) => $get('jenis_transaksi') === 'masuk'),

            TextInput::make('berat')
                ->label('Berat (Kg)')
                ->numeric()
                ->step(0.01)
                ->visible(fn ($get) => $get('jenis_transaksi') === 'masuk')
                ->reactive()
                ->afterStateUpdated(fn ($set, $get) =>
                    $set('subtotal', floatval($get('berat')) * floatval($get('harga_per_kg')))
                )
                ->requiredIf('jenis_transaksi', 'masuk'),

            TextInput::make('subtotal')
                ->label('Subtotal')
                ->numeric()
                ->prefix('Rp')
                ->required()
                ->readOnly(fn ($get) => $get('jenis_transaksi') === 'masuk')
                ->visible(fn ($get) => filled($get('jenis_transaksi')))
                ->dehydrated(),

            DatePicker::make('tanggal')
                ->label('Tanggal Transaksi')
                ->default(now())
                ->disabled()
                ->dehydrated(true)
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nasabah.nama')
                    ->label('Nasabah')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('jenis_transaksi')
                    ->label('Jenis')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'masuk' => 'success',
                        'keluar' => 'danger',
                    })
                    ->sortable(),

                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->filters([
                Filter::make('tanggal_range')
                    ->form([
                        DatePicker::make('from')->label('Dari'),
                        DatePicker::make('until')->label('Sampai'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'], fn ($q, $date) => $q->whereDate('tanggal', '>=', $date))
                            ->when($data['until'], fn ($q, $date) => $q->whereDate('tanggal', '<=', $date));
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('detail_transaksi')
                    ->icon('heroicon-o-eye')
                    ->modalHeading('Detail Transaksi')
                    ->modalContent(fn ($record) => view('components.transaksi.modal-detail-transaksi', [
                        'transaksi' => $record,
                    ]))
                    ->modalWidth('max-w-2xl')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close'),

                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('tanggal', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransaksis::route('/'),
            'create' => Pages\CreateTransaksi::route('/create'),
            'edit' => Pages\EditTransaksi::route('/{record}/edit'),
        ];
    }
}
