<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable =[
        'customer_id',
        'proposal_status_id',
        'largura',
        'altura',
        'valor_total',
        'tecido',
        'prazo_entrega',
        'fita_led',
        'obs_fita_led',
        'separadores',
        'obs_separadores',
        'tomadas',
        'obs_tomadas',
        'qtd_tomadas',
        'observacoes',
        'pgto_a_vista',
        'pgto_boleto',
        'pgto_cartao',
        'pgto_outros',
        'dias_validade'
    ];

    protected $casts = [
        'fita_led' => 'boolean',
        'separadores' => 'boolean',
        'tomadas' => 'boolean',
        'largura' => 'integer',
        'altura' => 'integer',
        'qtd_tomadas' => 'integer',
        'prazo_entrega' => 'integer',
    ];


    public function status()
    {
        return $this->belongsTo(ProposalStatus::class, 'proposal_status_id');
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function modulos(): HasMany
    {
        return $this->hasMany(ProposalModule::class);
    }
}
