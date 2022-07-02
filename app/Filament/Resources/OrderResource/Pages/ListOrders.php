<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Helpers\Helpers;
use App\Filament\Resources\OrderResource;
use App\Models\ContaReceber;
use App\Models\Order;
use Carbon\Carbon;
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

            if ($parcela_atual > 1) {
                $data['vencimento_em'] = Carbon::make($data['vencimento_em'])->addMonth(1)->format('Y-m-d');
            }

            if ($parcela_atual == $data['qtd_parcelas']) {

                $total_parcelas = bcmul($data['qtd_parcelas'], $data['valor_parcela'], 2);
                $diferenca = bcsub($data['valor_previsto'], $total_parcelas, 2);
                
                $data['valor_parcela'] = bcadd($data['valor_parcela'], $diferenca, 2);
            }

            $data['descricao'] = Helpers::getDescricaoReceber($data, $data['parcela_atual']);

            ContaReceber::create($data);          
            
            $parcela_atual++;

        }

        $order = Order::find($data['order_id']);
        $order->faturado = 1;
        $order->save();

        $this->notify('success', 'Pedido Faturado com Sucesso!');
    }
}
