<?php

namespace App\Filament\Resources\EstadoResource\Pages;

use App\Helpers\Helpers;
use App\Filament\Resources\EstadoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEstado extends CreateRecord
{
    protected static string $resource = EstadoResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return Helpers::arrayToUpper($data);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
