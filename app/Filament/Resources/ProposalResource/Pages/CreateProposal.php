<?php

namespace App\Filament\Resources\ProposalResource\Pages;

use App\Helpers\Helpers;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ProposalResource;

class CreateProposal extends CreateRecord
{
    protected static string $resource = ProposalResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
