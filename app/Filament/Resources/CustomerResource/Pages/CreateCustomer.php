<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Helpers\Helpers;
use App\Models\PfCustomer;
use App\Models\PjCustomer;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\CustomerResource;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return Helpers::arrayToUpper($data);
    }

    protected function handleRecordCreation(array $data): Model
    {
        
        $customer = static::getModel()::create($data);

        if ($data['person_type_id'] == 1) {

            $pf_customer = [
                'cpf' => $data['cpf'],
                'customer_id' => $customer->id
            ];
    
            PfCustomer::create($pf_customer);

        } else {

            $pj_customer = [
                'cnpj' => $data['cnpj'],
                'inscricao_estadual' => $data['inscricao_estadual'],
                'inscricao_municipal' => $data['inscricao_municipal'],
                'customer_id' => $customer->id
            ];
    
            PjCustomer::create($pj_customer);

        }

        return $customer;
    }
}
