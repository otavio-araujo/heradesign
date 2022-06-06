<?php

namespace App\Filament\Resources\SupplierResource\Pages;

use App\Helpers\Helpers;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\SupplierResource;
use App\Models\PfSupplier;
use App\Models\PjSupplier;

class CreateSupplier extends CreateRecord
{
    protected static string $resource = SupplierResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return Helpers::arrayToUpper($data);
    }

    protected function handleRecordCreation(array $data): Model
    {
        
        $supplier = static::getModel()::create($data);

        if ($data['person_type_id'] == 1) {

            $pf = [
                'cpf' => $data['cpf'],
                'supplier_id' => $supplier->id
            ];
    
            PfSupplier::create($pf);

        } else {

            $pj = [
                'cnpj' => $data['cnpj'],
                'inscricao_estadual' => $data['inscricao_estadual'],
                'inscricao_municipal' => $data['inscricao_municipal'],
                'supplier_id' => $supplier->id
            ];
    
            PjSupplier::create($pj);

        }

        return $supplier;
    }
}
