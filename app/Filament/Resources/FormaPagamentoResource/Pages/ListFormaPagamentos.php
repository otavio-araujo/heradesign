<?php

namespace App\Filament\Resources\FormaPagamentoResource\Pages;

use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\FormaPagamentoResource;

class ListFormaPagamentos extends ListRecords
{
    protected static string $resource = FormaPagamentoResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make()->label('Nova Forma de Pagamento'),
        ];
    }
}
