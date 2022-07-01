<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Helpers\Helpers;
use App\Filament\Resources\OrderResource;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getActions(): array
    {
        return [
            
        ];
    }

    public function faturarPedido(Array $data)
    {
        
        $parcela_atual = 1;

        while ($parcela_atual <= $data['qtd_parcelas']) {

            $data['parcela_atual'] = $parcela_atual;
            $data['descricao'] = Helpers::getDescricaoReceber($data, $data['parcela_atual']);
            

            
            $parcela_atual++;

        }

        $total_parcelas = bcmul($data['qtd_parcelas'], $data['valor_parcela'], 2);


        $valor = bcsub($data['valor_previsto'], $total_parcelas, 2);

        

        dd($valor);

        
        // dd($data);

        $this->notify('success', 'Pedido Faturado com Sucesso!');
    }
}
