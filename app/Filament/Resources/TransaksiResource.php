<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Transaksi;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TransaksiResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TransaksiResource\RelationManagers;

class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                $harga = \App\Models\JenisSampah::find($state)?->harga_per_kg ?? 0;
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
        ->required(),
]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('nasabah.nama')->label('Nasabah')->searchable(),
            TextColumn::make('jenis_transaksi')
            ->label('Jenis')
            ->badge()
            ->color(fn (string $state): string => match ($state) {
                'masuk' => 'success', // hijau
                'keluar' => 'danger', // merah
            }),
            TextColumn::make('jenisSampah.nama')->label('Jenis Sampah')->limit(20),
            TextColumn::make('berat')->label('Berat (Kg)'),
            TextColumn::make('subtotal')->label('Subtotal')->money('IDR', true),
            TextColumn::make('tanggal')->date('d M Y'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
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
            'index' => Pages\ListTransaksis::route('/'),
            'create' => Pages\CreateTransaksi::route('/create'),
            'edit' => Pages\EditTransaksi::route('/{record}/edit'),
        ];
    }
}
