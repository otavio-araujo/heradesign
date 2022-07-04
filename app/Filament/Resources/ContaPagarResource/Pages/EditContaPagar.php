<?php

namespace App\Filament\Resources\ContaPagarResource\Pages;

use App\Filament\Resources\ContaPagarResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContaPagar extends EditRecord
{
    protected static string $resource = ContaPagarResource::class;

    protected function getActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
