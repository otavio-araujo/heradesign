<?php

namespace App\Models;

use App\Models\Proposal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProposalItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao',
        'proposal_id',
        'qtd',
        'valor_unitario',
        'valor_total',
        'obs_item'
    ];

    protected $casts = [
        'qtd' => 'integer',
        'valor_unitario' => 'decimal: 2',
        'valor_total' => 'decimal: 2'
    ];

    public function proposal ()
    {
        return $this->belongsTo(Proposal::class);
    }

    protected function valorTotal(): Attribute
    {
        return Attribute::make(
            // get: fn ($value) => number_format($value, 2, ',', '.'),
            set: fn ($value, $attributes) => $attributes['qtd'] * $attributes['valor_unitario'],
        );
    }
}
