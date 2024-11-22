<?php

namespace App\Filament\Resources\ShipmentTypesResource\Pages;

use App\Filament\Resources\ShipmentTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShipmentTypes extends EditRecord
{
    protected static string $resource = ShipmentTypesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
