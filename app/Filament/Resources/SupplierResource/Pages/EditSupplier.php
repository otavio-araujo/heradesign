<?php

namespace App\Filament\Resources\SupplierResource\Pages;

use App\Helpers\Helpers;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\SupplierResource;

class EditSupplier extends EditRecord
{
    protected static string $resource = SupplierResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return Helpers::arrayToUpper($data);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
