<?php

namespace App\Filament\Resources\StatusContaResource\Pages;

use App\Filament\Resources\StatusContaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStatusContas extends ListRecords
{
    protected static string $resource = StatusContaResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
