<?php

namespace App\Filament\Resources\ReasonTransactionsCancellationResource\Pages;

use App\Filament\Resources\ReasonTransactionsCancellationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReasonTransactionsCancellation extends EditRecord
{
    protected static string $resource = ReasonTransactionsCancellationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
