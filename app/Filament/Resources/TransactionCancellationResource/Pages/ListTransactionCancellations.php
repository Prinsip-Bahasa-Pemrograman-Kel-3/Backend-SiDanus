<?php

namespace App\Filament\Resources\TransactionCancellationResource\Pages;

use App\Filament\Resources\TransactionCancellationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransactionCancellations extends ListRecords
{
    protected static string $resource = TransactionCancellationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
