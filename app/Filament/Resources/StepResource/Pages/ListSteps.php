<?php

namespace App\Filament\Resources\StepResource\Pages;

use App\Filament\Resources\StepResource;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSteps extends ListRecords
{
    protected static string $resource = StepResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make()->label('Novo Acompanhamento de Pedido'),
        ];
    }

}
