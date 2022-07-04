<?php

namespace App\Filament\Resources\ContaReceberResource\Pages;

use Filament\Pages\Actions;
use App\Models\ContaReceber;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ContaReceberResource;
use App\Models\ContaCorrente;
use App\Models\Transaction;
use Carbon\Carbon;

class ListContaRecebers extends ListRecords
{
    protected static string $resource = ContaReceberResource::class;

    protected function getActions(): array
    {
        return [
            // Actions\CreateAction::make()->visible(false),
        ];
    }


    public function baixarConta(Array $data)
    {
        
        /* BAIXANDO A CONTA */
        $data['status_conta_id'] = 3;

        $conta = ContaReceber::find($data['id']);

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
            'conta_receber_id' => $conta->id,
            'liquidado_em' => $conta->liquidado_em,
            'valor' => $conta->valor_pago,
        ];

        $transction = Transaction::create($transaction_data);

        /* ATUALIZANDO O SALDO DA CONTA COM O VALOR DA TRANSAÇÃO ATUAL */
        $conta_corrente = ContaCorrente::find($conta->contaCorrente->id);
        $conta_corrente->saldo_atual = bcadd($conta->contaCorrente->saldo_atual, $conta->valor_pago, 2);
        $conta_corrente->save();

        $this->notify('success', 'Conta Liquidada com Sucesso!');
    }


    public function cancelarBaixa(ContaReceber $record)
    {
        
        /* Localiza a transação e apaga do banco de dados */
        $transaction = $record->transaction;
        $transaction->delete();
        
        /* Localiza a conta corrente e atualiza o saldo_atual */
        $conta_corrente = $record->contaCorrente;
        $conta_corrente->saldo_atual = bcsub($conta_corrente->saldo_atual, $record->valor_pago, 2);
        $conta_corrente->save();
    
        /* Atualiza os dados do ContasReceber */
        if ($record->vencimento_em->lt(Carbon::now()->format('Y-m-d')) === true) {
            
            $record->update([
                'status_conta_id' => 2,
                'valor_pago' => null,
                'pago_em' => null,
                'liquidado_em' => null,
                'valor_descontos' => 0.00,
                'valor_acrescimos' => 0.00,  
            ]);

        } else {

            $record->update([
                'status_conta_id' => 1,
                'valor_pago' => null,
                'pago_em' => null,
                'liquidado_em' => null,
                'valor_descontos' => 0.00,
                'valor_acrescimos' => 0.00,  
            ]);
        }

        $this->notify('success', 'Baixa de Conta Cancelada com Sucesso!');
        
    }
}
