<?php

namespace App\Filament\Resources\FornecedorResource\Pages;

use App\Helpers\Helpers;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\FornecedorResource;

class CreateFornecedor extends CreateRecord
{
    protected static string $resource = FornecedorResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return Helpers::arrayToUpper($data);
    }

}

