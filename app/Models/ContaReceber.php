<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContaReceber extends Model
{
    use HasFactory;

    protected $table = 'contas_receber';

    protected $fillable = [
        'order_id',
        'proposal_id',
        'customer_id', 
        'conta_corrente_id',
        'plano_conta_id',
        'categoria_conta_id',
        'forma_pagamento_id',
        'status_conta_id',
        'descricao',
        'parcela_atual',
        'qtd_parcelas',
        'valor_previsto',
        'valor_parcela',
        'valor_descontos',
        'valor_acrescimos',
        'vencimento_em',
        'pago_em',
        'liquidado_em',
        'documento',
        'observacoes',
    ];

    protected $casts = [
        'order_id' => 'integer',
        'proposal_id' => 'integer',
        'customer_id' => 'integer',
        'conta_corrente_id' => 'integer',
        'plano_conta_id' => 'integer',
        'categoria_conta_id' => 'integer',
        'forma_pagamento_id' => 'integer',
        'status_conta_id' => 'integer',
        'parcela_atual' => 'integer',
        'qtd_parcelas' => 'integer',
        'valor_previsto' => 'decimal:2',
        'valor_parcela' => 'decimal:2',
        'valor_descontos' => 'decimal:2',
        'valor_acrescimos' => 'decimal:2',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'liquidado_em',
        'pago_em',
        'vencimento_em'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function contaCorrente()
    {
        return $this->belongsTo(ContaCorrente::class, 'conta_corrente_id');
    }

    public function statusConta()
    {
        return $this->belongsTo(StatusConta::class, 'status_conta_id');
    }

    public function categoriaConta()
    {
        return $this->belongsTo(CategoriaConta::class, 'categoria_conta_id');
    }

    public function planoConta()
    {
        return $this->belongsTo(PlanoConta::class, 'plano_conta_id');
    }

    public function formaPagamento()
    {
        return $this->belongsTo(FormaPagamento::class, 'forma_pagamento_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'conta_receber_id');
    }

    protected function descricao(): Attribute
    {
        
        return Attribute::make(
            set: fn ($value) => mb_strtoupper($value),
        );
    }

}
