<?php

namespace App\Filament\Resources\DetailTransactionsResource\Pages;

use App\Filament\Resources\DetailTransactionsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDetailTransactions extends EditRecord
{
    protected static string $resource = DetailTransactionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
