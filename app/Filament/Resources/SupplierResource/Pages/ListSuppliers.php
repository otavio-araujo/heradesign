<?php

namespace App\Filament\Resources\SupplierResource\Pages;

use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\SupplierResource;
use App\Filament\Resources\SupplierResource\Pages\CreateSupplier;
use Filament\Resources\Pages\CreateRecord;

class ListSuppliers extends ListRecords
{
    protected static string $resource = SupplierResource::class;

}
