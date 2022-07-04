<?php

namespace App\Filament\Resources\PlanoContaResource\Pages;

use App\Filament\Resources\PlanoContaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlanoContas extends ListRecords
{
    protected static string $resource = PlanoContaResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Novo Plano de Conta'),
        ];
    }
}
