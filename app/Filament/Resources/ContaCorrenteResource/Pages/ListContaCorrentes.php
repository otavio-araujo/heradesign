<?php

namespace App\Filament\Resources\ContaCorrenteResource\Pages;

use App\Filament\Resources\ContaCorrenteResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContaCorrentes extends ListRecords
{
    protected static string $resource = ContaCorrenteResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
