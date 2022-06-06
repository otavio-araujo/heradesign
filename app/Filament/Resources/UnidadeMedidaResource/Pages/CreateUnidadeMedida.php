<?php

namespace App\Filament\Resources\UnidadeMedidaResource\Pages;

use App\Helpers\Helpers;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\UnidadeMedidaResource;

class CreateUnidadeMedida extends CreateRecord
{
    protected static string $resource = UnidadeMedidaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return Helpers::arrayToUpper($data);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
