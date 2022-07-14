<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\CustomerResource;

class ListCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make()->label('Novo Cliente'),
        ];
    }
}
