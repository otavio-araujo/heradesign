<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Helpers\Helpers;
use App\Models\PfCustomer;
use App\Models\PjCustomer;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\CustomerResource;

class EditCustomer extends EditRecord
{
    protected static string $resource = CustomerResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return Helpers::arrayToUpper($data);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        
        if ($data['person_type_id'] == 1) {

            $pf = PfCustomer::firstWhere('customer_id', $data['id']);
            $data['cpf'] = $pf->cpf; 

        } else if ($data['person_type_id'] == 2) {

            $pj = PjCustomer::firstWhere('customer_id', $data['id']);
            $data['cnpj'] = $pj->cnpj;
            $data['inscricao_municipal'] = $pj->inscricao_municipal;
            $data['inscricao_estadual'] = $pj->inscricao_estadual;

        }
    
        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        
        $record->update($data);

        if ($data['person_type_id'] == 1) {

            if (PfCustomer::where('customer_id', $record->id)->count() == 1) {

                // dd($data);

                $pf = PfCustomer::firstWhere('customer_id', $record->id);

                $pf->cpf = $data['cpf'];
            
                $pf->save();

            } else {

                // dd($data);

                $pf_customer = [
                    'cpf' => $data['cpf'],
                    'customer_id' => $record->id
                ];
        
                PfCustomer::create($pf_customer);

            }

        } else {

            if (PjCustomer::where('customer_id', $record->id)->count() == 1) {

                $pf = PjCustomer::firstWhere('customer_id', $record->id);


                $pf->cnpj = $data['cnpj'];
                $pf->inscricao_estadual = $data['inscricao_estadual'];
                $pf->inscricao_municipal = $data['inscricao_municipal'];
            
                $pf->save();

            } else {

                $pj_customer = [
                    'cnpj' => $data['cnpj'],
                    'inscricao_estadual' => $data['inscricao_estadual'],
                    'inscricao_municipal' => $data['inscricao_municipal'],
                    'customer_id' => $record->id
                ];
        
                PjCustomer::create($pj_customer);

            }

        }
    
        return $record;
    }
    
}
