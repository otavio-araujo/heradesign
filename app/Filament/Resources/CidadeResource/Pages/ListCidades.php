<?php

namespace App\Filament\Resources\CidadeResource\Pages;

use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\CidadeResource;

class ListCidades extends ListRecords
{
    protected static string $resource = CidadeResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make()->label('Nova Cidade'),
        ];
    }
}
