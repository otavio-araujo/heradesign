<?php

namespace App\Filament\Resources\ContaPagarResource\Pages;

use Carbon\Carbon;
use App\Helpers\Helpers;
use Filament\Pages\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ContaPagarResource;
use App\Models\ContaPagar;

class CreateContaPagar extends CreateRecord
{
    protected static string $resource = ContaPagarResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        
        $parcela_atual = 1;

        while ($parcela_atual <= $data['qtd_parcelas']) {

            $data['parcela_atual'] = $parcela_atual;

            if ($parcela_atual > 1) {
                $data['vencimento_em'] = Carbon::make($data['vencimento_em'])->addMonth(1)->format('Y-m-d');
            }

            if ($parcela_atual == $data['qtd_parcelas']) {

                $total_parcelas = bcmul($data['qtd_parcelas'], $data['valor_parcela'], 2);
                $diferenca = bcsub($data['valor_previsto'], $total_parcelas, 2);
                
                $data['valor_parcela'] = bcadd($data['valor_parcela'], $diferenca, 2);
            }

            $data['descricao'] = Helpers::getDescricaoPagar($data, $data['parcela_atual']);

            $last_conta = ContaPagar::create($data);          
            
            $parcela_atual++;

        }

        $this->notify('success', 'Conta a Pagar Lançada com Sucesso!');

        return $last_conta;
        
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
