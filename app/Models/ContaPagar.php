<?php

namespace App\Models;

use App\Models\PlanoConta;
use App\Models\StatusConta;
use App\Models\Transaction;
use App\Models\ContaCorrente;
use App\Models\CategoriaConta;
use App\Models\FormaPagamento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContaPagar extends Model
{
    use HasFactory;

    protected $table = 'contas_pagar';

    protected $fillable = [
        'supplier_id', 
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
        'supplier_id' => 'integer',
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

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
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
        return $this->hasOne(Transaction::class, 'conta_pagar_id');
    }

    protected function descricao(): Attribute
    {
        
        return Attribute::make(
            set: fn ($value) => mb_strtoupper($value),
        );
    }

    protected function documento(): Attribute
    {
        
        return Attribute::make(
            set: fn ($value) => mb_strtoupper($value),
        );
    }

    protected function observacoes(): Attribute
    {
        
        return Attribute::make(
            set: fn ($value) => mb_strtoupper($value),
        );
    }
    
}
