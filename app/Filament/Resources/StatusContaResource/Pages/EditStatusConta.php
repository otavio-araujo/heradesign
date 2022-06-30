<?php

namespace App\Filament\Resources\StatusContaResource\Pages;

use App\Filament\Resources\StatusContaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStatusConta extends EditRecord
{
    protected static string $resource = StatusContaResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
