<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionCancellationResource\Pages;
use App\Filament\Resources\TransactionCancellationResource\RelationManagers;
use App\Models\TransactionsCancellations;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionCancellationResource extends Resource
{
    protected static ?string $model = TransactionsCancellations::class;

    protected static ?string $navigationIcon = 'heroicon-o-x-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('transaction_id')
                    ->relationship('transaction', 'id')
                    ->required()
                    ->label('Transaction'),
                Forms\Components\Select::make('reason_cancellation_id')
                    ->relationship('reason', 'name')
                    ->required()
                    ->label('Reason'),
                Forms\Components\Textarea::make('description')
                    ->label('Description'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('transaction.id')
                    ->label('Transaction')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('reason.name')
                    ->label('Reason')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime(),
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
            'index' => Pages\ListTransactionCancellations::route('/'),
            'create' => Pages\CreateTransactionCancellation::route('/create'),
            'edit' => Pages\EditTransactionCancellation::route('/{record}/edit'),
        ];
    }
}