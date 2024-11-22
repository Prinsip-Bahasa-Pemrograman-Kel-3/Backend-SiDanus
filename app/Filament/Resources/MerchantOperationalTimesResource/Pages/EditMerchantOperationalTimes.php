<?php

namespace App\Filament\Resources\MerchantOperationalTimesResource\Pages;

use App\Filament\Resources\MerchantOperationalTimesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMerchantOperationalTimes extends EditRecord
{
    protected static string $resource = MerchantOperationalTimesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
