<?php

namespace App\Filament\Resources\FormaPagamentoResource\Pages;

use App\Filament\Resources\FormaPagamentoResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFormaPagamento extends CreateRecord
{
    protected static string $resource = FormaPagamentoResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
