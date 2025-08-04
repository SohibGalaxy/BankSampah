<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Nasabah;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\NasabahResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\NasabahResource\RelationManagers;

class NasabahResource extends Resource
{
    protected static ?string $model = Nasabah::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
           ->schema([
                TextInput::make('nama')
                    ->required()
                    ->maxLength(255),

                TextInput::make('alamat')
                    ->required()
                    ->maxLength(255),

                TextInput::make('no_telpon')
                    ->label('No. Telepon')
                    ->tel()
                    ->maxLength(20),

                TextInput::make('telegram_chat_id')
                    ->maxLength(100)
                    ->label('Telegram Chat ID'),

                DatePicker::make('tgl_daftar')
                    ->label('Tanggal Daftar')
                    ->required()
                    ->default(now()),
                   
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('nama')->searchable()->sortable(),
            TextColumn::make('alamat')->limit(30)->wrap(),
            TextColumn::make('no_telpon')->label('No. Telpon'),
            TextColumn::make('telegram_chat_id')->label('Telegram'),
            TextColumn::make('tgl_daftar')->label('Tanggal Daftar')->date('d M Y'), //
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
            'index' => Pages\ListNasabahs::route('/'),
            'create' => Pages\CreateNasabah::route('/create'),
            'edit' => Pages\EditNasabah::route('/{record}/edit'),
        ];
    }
}
