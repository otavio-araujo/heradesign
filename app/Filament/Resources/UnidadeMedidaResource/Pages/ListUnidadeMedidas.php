<?php

namespace App\Filament\Resources\UnidadeMedidaResource\Pages;

use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\UnidadeMedidaResource;

class ListUnidadeMedidas extends ListRecords
{
    protected static string $resource = UnidadeMedidaResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make()->label('Nova Unidade de Medida'),
        ];
    }
}
