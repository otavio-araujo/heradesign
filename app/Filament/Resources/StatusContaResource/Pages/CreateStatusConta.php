<?php

namespace App\Filament\Resources\StatusContaResource\Pages;

use App\Filament\Resources\StatusContaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStatusConta extends CreateRecord
{
    protected static string $resource = StatusContaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
