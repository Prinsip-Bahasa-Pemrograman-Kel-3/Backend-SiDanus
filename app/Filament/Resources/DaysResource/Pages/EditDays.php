<?php

namespace App\Filament\Resources\DaysResource\Pages;

use App\Filament\Resources\DaysResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDays extends EditRecord
{
    protected static string $resource = DaysResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
