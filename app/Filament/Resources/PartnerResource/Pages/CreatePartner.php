<?php

namespace App\Filament\Resources\PartnerResource\Pages;

use App\Helpers\Helpers;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PartnerResource;
use App\Models\PfPartner;
use App\Models\PjPartner;

class CreatePartner extends CreateRecord
{
    protected static string $resource = PartnerResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return Helpers::arrayToUpper($data);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function handleRecordCreation(array $data): Model
    {
        
        $partner = static::getModel()::create($data);

        if ($data['person_type_id'] == 1) {

            $pf = [
                'cpf' => $data['cpf'],
                'partner_id' => $partner->id
            ];
    
            PfPartner::create($pf);

        } else {

            $pj = [
                'cnpj' => $data['cnpj'],
                'inscricao_estadual' => $data['inscricao_estadual'],
                'inscricao_municipal' => $data['inscricao_municipal'],
                'partner_id' => $partner->id
            ];
    
            PjPartner::create($pj);

        }

        return $partner;
    }
}
