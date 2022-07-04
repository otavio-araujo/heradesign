<?php

namespace App\Filament\Resources\CategoriaContaResource\Pages;

use App\Filament\Resources\CategoriaContaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategoriaConta extends EditRecord
{
    protected static string $resource = CategoriaContaResource::class;

    protected function getActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
