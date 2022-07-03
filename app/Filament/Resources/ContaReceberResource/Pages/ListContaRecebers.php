<?php

namespace App\Filament\Resources\ContaReceberResource\Pages;

use Filament\Pages\Actions;
use App\Models\ContaReceber;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ContaReceberResource;

class ListContaRecebers extends ListRecords
{
    protected static string $resource = ContaReceberResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }


    public function baixarConta(Array $data)
    {
        $data['status_conta_id'] = 3;

        $conta = ContaReceber::find($data['id']);

        $conta->pago_em = $data['pago_em'];
        $conta->liquidado_em = $data['liquidado_em'];
        $conta->valor_descontos = $data['valor_descontos'];
        $conta->valor_acrescimos = $data['valor_acrescimos'];
        $conta->valor_pago = $data['valor_pago'];
        $conta->status_conta_id = $data['status_conta_id'];

        $conta->save();



        $this->notify('success', 'Conta Liquidada com Sucesso!');
    }
}
