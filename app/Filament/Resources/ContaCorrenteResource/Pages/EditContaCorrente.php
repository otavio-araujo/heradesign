<?php

namespace App\Filament\Resources\ContaCorrenteResource\Pages;

use App\Filament\Resources\ContaCorrenteResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContaCorrente extends EditRecord
{
    protected static string $resource = ContaCorrenteResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
