<?php

namespace App\Filament\Resources\CidadeResource\Pages;

use App\Helpers\Helpers;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\CidadeResource;

class EditCidade extends EditRecord
{
    protected static string $resource = CidadeResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return Helpers::arrayToUpper($data);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
