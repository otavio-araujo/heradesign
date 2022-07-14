<?php

namespace App\Filament\Resources\EstadoResource\Pages;

use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\EstadoResource;

class ListEstados extends ListRecords
{
    protected static string $resource = EstadoResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make()->label('Novo Estado'),
        ];
    }
}
