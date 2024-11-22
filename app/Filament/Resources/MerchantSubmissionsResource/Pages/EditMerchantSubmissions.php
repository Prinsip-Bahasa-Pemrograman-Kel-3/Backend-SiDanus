<?php

namespace App\Filament\Resources\MerchantSubmissionsResource\Pages;

use App\Filament\Resources\MerchantSubmissionsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMerchantSubmissions extends EditRecord
{
    protected static string $resource = MerchantSubmissionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
