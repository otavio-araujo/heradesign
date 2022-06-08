<?php

namespace App\Filament\Resources\ProposalResource\Pages;

use App\Helpers\Helpers;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\ProposalResource;

class EditProposal extends EditRecord
{
    protected static string $resource = ProposalResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
