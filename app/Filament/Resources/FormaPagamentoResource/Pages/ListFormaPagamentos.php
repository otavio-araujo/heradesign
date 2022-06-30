<?php

namespace App\Filament\Resources\FormaPagamentoResource\Pages;

use App\Filament\Resources\FormaPagamentoResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFormaPagamentos extends ListRecords
{
    protected static string $resource = FormaPagamentoResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
