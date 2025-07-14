<?php

namespace App\Filament\Resources;

use App\Models\Tabungan;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\TabunganResource\Pages;

class TabunganResource extends Resource
{
    protected static ?string $model = Tabungan::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'Tabungan';
    protected static ?string $pluralModelLabel = 'Tabungan';
    protected static ?string $navigationGroup = 'Keuangan';

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nasabah.nama')
                    ->label('Nama Nasabah')
                    ->searchable(),
                TextColumn::make('saldo')
                    ->label('Saldo')
                    ->money('IDR', true),
                TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->since(),
            ])
            ->defaultSort('updated_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTabungans::route('/'),
        ];
    }
}
