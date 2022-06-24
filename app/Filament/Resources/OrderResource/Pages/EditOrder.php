<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Helpers\Helpers;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
{
    $data['id'] = Helpers::setProposalNumber($data['id']);
    $data['proposal_id'] = Helpers::setProposalNumber($data['proposal_id']);
 
    return $data;
}
}
