<?php

namespace App\Filament\Resources\CategoriaContaResource\Pages;

use App\Filament\Resources\CategoriaContaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategoriaContas extends ListRecords
{
    protected static string $resource = CategoriaContaResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
