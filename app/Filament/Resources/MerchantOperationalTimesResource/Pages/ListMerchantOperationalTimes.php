<?php

namespace App\Filament\Resources\MerchantOperationalTimesResource\Pages;

use App\Filament\Resources\MerchantOperationalTimesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMerchantOperationalTimes extends ListRecords
{
    protected static string $resource = MerchantOperationalTimesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
