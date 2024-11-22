<?php

namespace App\Filament\Resources\ReasonTransactionsCancellationResource\Pages;

use App\Filament\Resources\ReasonTransactionsCancellationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReasonTransactionsCancellations extends ListRecords
{
    protected static string $resource = ReasonTransactionsCancellationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
