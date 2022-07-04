<?php

namespace App\Filament\Resources\ContaPagarResource\Pages;

use App\Models\ContaPagar;
use App\Models\Transaction;
use Filament\Pages\Actions;
use App\Models\ContaCorrente;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ContaPagarResource;

class ListContaPagars extends ListRecords
{
    protected static string $resource = ContaPagarResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Nova Conta a Pagar'),
        ];
    }

    public function baixarConta(Array $data)
    {
        
        /* BAIXANDO A CONTA */
        $data['status_conta_id'] = 3;

        $conta = ContaPagar::find($data['id']);

        $conta->pago_em = $data['pago_em'];
        $conta->liquidado_em = $data['liquidado_em'];
        $conta->valor_descontos = $data['valor_descontos'];
        $conta->valor_acrescimos = $data['valor_acrescimos'];
        $conta->valor_pago = $data['valor_pago'];
        $conta->status_conta_id = $data['status_conta_id'];  

        $conta->save();

        /* LANÇANDO EM TRANSACTIONS */
        $transaction_data = [
            'conta_corrente_id' => $conta->contaCorrente->id,
            'conta_pagar_id' => $conta->id,
            'liquidado_em' => $conta->liquidado_em,
            'valor' => $conta->valor_pago,
        ];

        $transction = Transaction::create($transaction_data);

        /* ATUALIZANDO O SALDO DA CONTA COM O VALOR DA TRANSAÇÃO ATUAL */
        $conta_corrente = ContaCorrente::find($conta->contaCorrente->id);
        $conta_corrente->saldo_atual = bcsub($conta->contaCorrente->saldo_atual, $conta->valor_pago, 2);
        $conta_corrente->save();

        $this->notify('success', 'Conta Liquidada com Sucesso!');
    }

}
