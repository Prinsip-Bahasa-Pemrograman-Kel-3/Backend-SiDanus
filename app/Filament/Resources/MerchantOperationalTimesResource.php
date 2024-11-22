<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MerchantOperationalTimesResource\Pages;
use App\Filament\Resources\MerchantOperationalTimesResource\RelationManagers;
use App\Models\MerchantOperationalTimes;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MerchantOperationalTimesResource extends Resource
{
    protected static ?string $model = MerchantOperationalTimes::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('day_id')
                    ->relationship('day', 'name')
                    ->required(),
                Forms\Components\Select::make('merchant_id')
                    ->relationship('merchant', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('day.name')
                    ->label('Day')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('merchant.name')
                    ->label('Merchant')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListMerchantOperationalTimes::route('/'),
            'create' => Pages\CreateMerchantOperationalTimes::route('/create'),
            'edit' => Pages\EditMerchantOperationalTimes::route('/{record}/edit'),
        ];
    }
}