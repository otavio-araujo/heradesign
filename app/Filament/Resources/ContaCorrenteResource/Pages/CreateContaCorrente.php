<?php

namespace App\Filament\Resources\ContaCorrenteResource\Pages;

use App\Filament\Resources\ContaCorrenteResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateContaCorrente extends CreateRecord
{
    protected static string $resource = ContaCorrenteResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
