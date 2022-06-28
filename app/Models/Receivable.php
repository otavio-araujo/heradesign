<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receivable extends Model
{
    use HasFactory;

    protected $fillable = [
        'proposal_id',
        'order_id',
        'customer_id',
        'billing_statatus_id',
        'billing_type_id',
        'descricao',
        'qtd_parcelas',
        'parcela_atual',
        'valor_total',
        'valor_parcela',
        'valor_desconto',
        'valor_acrescimo',
        'valor_pago',
        'vencimento_em',
        'pago_em',
        'liquidado_em',
        'documento',
        'observacoes',
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function billingStatus()
    {
        return $this->belongsTo(BillingStatus::class, 'billing_statatus_id');
    }

    public function billingType()
    {
        return $this->belongsTo(BillingStatus::class, 'billing_type_id');
    }
}
