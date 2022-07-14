<?php

namespace App\Filament\Resources\SupplierResource\Pages;

use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\SupplierResource;
use App\Filament\Resources\SupplierResource\Pages\CreateSupplier;

class ListSuppliers extends ListRecords
{
    protected static string $resource = SupplierResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make()->label('Novo Fornecedor'),
        ];
    }

}
