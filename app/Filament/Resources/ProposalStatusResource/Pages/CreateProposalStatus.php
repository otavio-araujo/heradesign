<?php

namespace App\Filament\Resources\ProposalStatusResource\Pages;

use App\Filament\Resources\ProposalStatusResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProposalStatus extends CreateRecord
{
    protected static string $resource = ProposalStatusResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
