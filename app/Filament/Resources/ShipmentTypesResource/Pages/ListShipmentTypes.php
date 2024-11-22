<?php

namespace App\Filament\Resources\ShipmentTypesResource\Pages;

use App\Filament\Resources\ShipmentTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListShipmentTypes extends ListRecords
{
    protected static string $resource = ShipmentTypesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
