<?php

namespace App\Filament\Resources\MerchantSubmissionsResource\Pages;

use App\Filament\Resources\MerchantSubmissionsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMerchantSubmissions extends ListRecords
{
    protected static string $resource = MerchantSubmissionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
