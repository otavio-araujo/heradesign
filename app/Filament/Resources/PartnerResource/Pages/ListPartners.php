<?php

namespace App\Filament\Resources\PartnerResource\Pages;

use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PartnerResource;

class ListPartners extends ListRecords
{
    protected static string $resource = PartnerResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make()->label('Novo Parceiro'),
        ];
    }
}
