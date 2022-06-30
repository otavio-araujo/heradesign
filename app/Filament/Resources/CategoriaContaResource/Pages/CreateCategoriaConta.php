<?php

namespace App\Filament\Resources\CategoriaContaResource\Pages;

use App\Filament\Resources\CategoriaContaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCategoriaConta extends CreateRecord
{
    protected static string $resource = CategoriaContaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
