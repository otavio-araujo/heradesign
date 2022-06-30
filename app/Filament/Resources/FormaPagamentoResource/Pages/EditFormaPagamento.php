<?php

namespace App\Filament\Resources\FormaPagamentoResource\Pages;

use App\Filament\Resources\FormaPagamentoResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFormaPagamento extends EditRecord
{
    protected static string $resource = FormaPagamentoResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
