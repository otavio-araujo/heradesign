<?php

namespace App\Filament\Resources\EstadoResource\Pages;

use App\Helpers\Helpers;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\EstadoResource;

class EditEstado extends EditRecord
{
    protected static string $resource = EstadoResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return Helpers::arrayToUpper($data);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
