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
        'separadores',
        'observacoes',
    ];

    protected $casts = [
        'fita_led' => 'boolean',
        'separadores' => 'boolean',
        'largura' => 'integer',
        'altura' => 'integer',
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
