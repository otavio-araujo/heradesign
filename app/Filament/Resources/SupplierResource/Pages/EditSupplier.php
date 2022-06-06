<?php

namespace App\Filament\Resources\SupplierResource\Pages;

use App\Helpers\Helpers;
use App\Models\PfSupplier;
use App\Models\PjSupplier;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\SupplierResource;

class EditSupplier extends EditRecord
{
    protected static string $resource = SupplierResource::class;

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

            if (PfSupplier::firstWhere('supplier_id', $data['id']) != null) {

                $pf = PfSupplier::firstWhere('supplier_id', $data['id']);  
                $data['cpf'] = $pf->cpf; 

            }          

        } else if ($data['person_type_id'] == 2) {

            if (PjSupplier::firstWhere('supplier_id', $data['id']) != null) {


                $pj = PjSupplier::firstWhere('supplier_id', $data['id']);
                $data['cnpj'] = $pj->cnpj;
                $data['inscricao_municipal'] = $pj->inscricao_municipal;
                $data['inscricao_estadual'] = $pj->inscricao_estadual;
                
            }

        }
    
        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        
        $record->update($data);

        if ($data['person_type_id'] == 1) {

            if (PfSupplier::where('supplier_id', $record->id)->count() == 1) {

                // dd($data);

                $pf = PfSupplier::firstWhere('supplier_id', $record->id);

                $pf->cpf = $data['cpf'];
            
                $pf->save();

            } else {

                // dd($data);

                $pf = [
                    'cpf' => $data['cpf'],
                    'supplier_id' => $record->id
                ];
        
                PfSupplier::create($pf);

            }

        } else {

            if (PjSupplier::where('supplier_id', $record->id)->count() == 1) {

                $pf = PjSupplier::firstWhere('supplier_id', $record->id);


                $pf->cnpj = $data['cnpj'];
                $pf->inscricao_estadual = $data['inscricao_estadual'];
                $pf->inscricao_municipal = $data['inscricao_municipal'];
            
                $pf->save();

            } else {

                $pj = [
                    'cnpj' => $data['cnpj'],
                    'inscricao_estadual' => $data['inscricao_estadual'],
                    'inscricao_municipal' => $data['inscricao_municipal'],
                    'supplier_id' => $record->id
                ];
        
                PjSupplier::create($pj);

            }

        }
    
        return $record;
    }
}
