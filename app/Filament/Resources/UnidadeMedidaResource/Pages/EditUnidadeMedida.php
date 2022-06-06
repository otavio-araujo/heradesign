<?php

namespace App\Filament\Resources\UnidadeMedidaResource\Pages;

use App\Helpers\Helpers;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\UnidadeMedidaResource;

class EditUnidadeMedida extends EditRecord
{
    protected static string $resource = UnidadeMedidaResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return Helpers::arrayToUpper($data);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
