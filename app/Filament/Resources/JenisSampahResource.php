<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\JenisSampah;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\JenisSampahResource\Pages;
use App\Filament\Resources\JenisSampahResource\RelationManagers;

class JenisSampahResource extends Resource
{
    protected static ?string $model = JenisSampah::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                 TextInput::make('nama')
                ->label('Nama Sampah')
                ->required()
                ->maxLength(100),

                TextInput::make('harga_per_kg')
                    ->label('Harga per Kg')
                    ->numeric()
                    ->required()
                    ->prefix('Rp')
                    ->rules(['numeric', 'min:0']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
               TextColumn::make('nama')
                ->label('Jenis Sampah')
                ->searchable()
                ->sortable(),

            TextColumn::make('harga_per_kg')
                ->label('Harga per Kg')
                ->money('IDR', true)
                ->sortable(),
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
            'index' => Pages\ListJenisSampahs::route('/'),
            'create' => Pages\CreateJenisSampah::route('/create'),
            'edit' => Pages\EditJenisSampah::route('/{record}/edit'),
        ];
    }
}
