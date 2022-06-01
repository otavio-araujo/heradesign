<?php

namespace App\Filament\Resources\CidadeResource\Pages;

use App\Helpers\Helpers;
use App\Filament\Resources\CidadeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCidade extends CreateRecord
{
    protected static string $resource = CidadeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return Helpers::arrayToUpper($data);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
