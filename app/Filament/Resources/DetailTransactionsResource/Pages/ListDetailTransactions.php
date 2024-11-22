<?php

namespace App\Filament\Resources\DetailTransactionsResource\Pages;

use App\Filament\Resources\DetailTransactionsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDetailTransactions extends ListRecords
{
    protected static string $resource = DetailTransactionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
