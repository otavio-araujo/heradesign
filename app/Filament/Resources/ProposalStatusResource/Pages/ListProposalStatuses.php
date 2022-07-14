<?php

namespace App\Filament\Resources\ProposalStatusResource\Pages;

use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ProposalStatusResource;

class ListProposalStatuses extends ListRecords
{
    protected static string $resource = ProposalStatusResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make()->label('Novo Status de Proposta'),
        ];
    }
}
