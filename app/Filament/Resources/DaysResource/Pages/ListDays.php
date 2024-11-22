<?php

namespace App\Filament\Resources\DaysResource\Pages;

use App\Filament\Resources\DaysResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDays extends ListRecords
{
    protected static string $resource = DaysResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
