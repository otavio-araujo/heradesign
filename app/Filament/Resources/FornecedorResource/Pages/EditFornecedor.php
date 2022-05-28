<?php

namespace App\Filament\Resources\FornecedorResource\Pages;

use App\Helpers\Helpers;
use Illuminate\Support\Str;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\FornecedorResource;

class EditFornecedor extends EditRecord
{
    protected static string $resource = FornecedorResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return Helpers::arrayToUpper($data);
    }

}
