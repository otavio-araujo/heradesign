<?php

namespace App\Filament\Resources\PartnerResource\Pages;

use App\Helpers\Helpers;
use App\Models\PfPartner;
use App\Models\PjPartner;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\PartnerResource;

class EditPartner extends EditRecord
{
    protected static string $resource = PartnerResource::class;

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

            if (PfPartner::firstWhere('partner_id', $data['id']) != null) {

                $pf = PfPartner::firstWhere('partner_id', $data['id']);  
                $data['cpf'] = $pf->cpf; 

            }

        } else if ($data['person_type_id'] == 2) {

            if (PjPartner::firstWhere('partner_id', $data['id']) != null) {


                $pj = PjPartner::firstWhere('partner_id', $data['id']);
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

            if (PfPartner::where('partner_id', $record->id)->count() == 1) {

                // dd($data);

                $pf = PfPartner::firstWhere('partner_id', $record->id);

                $pf->cpf = $data['cpf'];
            
                $pf->save();

            } else {

                // dd($data);

                $pf_customer = [
                    'cpf' => $data['cpf'],
                    'partner_id' => $record->id
                ];
        
                PfPartner::create($pf_customer);

            }

        } else {

            if (PjPartner::where('partner_id', $record->id)->count() == 1) {

                $pf = PjPartner::firstWhere('partner_id', $record->id);


                $pf->cnpj = $data['cnpj'];
                $pf->inscricao_estadual = $data['inscricao_estadual'];
                $pf->inscricao_municipal = $data['inscricao_municipal'];
            
                $pf->save();

            } else {

                $pj_customer = [
                    'cnpj' => $data['cnpj'],
                    'inscricao_estadual' => $data['inscricao_estadual'],
                    'inscricao_municipal' => $data['inscricao_municipal'],
                    'partner_id' => $record->id
                ];
        
                PjPartner::create($pj_customer);

            }

        }
    
        return $record;
    }
}
