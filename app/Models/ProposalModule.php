<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProposalModule extends Model
{
    use HasFactory;

    protected $fillable =[
        'formato',
        'largura',
        'altura',
        'quantidade',
        'proposal_id',
        'observacoes'
    ];

    protected $casts = [
        'quantidade' => 'integer',
        'largura' => 'integer',
        'altura' => 'integer',
    ];

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class);
    }


    protected function formato(): Attribute
    {
        return Attribute::make(
            // get: fn ($value) => ucfirst($value),
            set: fn ($value) => mb_strtoupper($value),
        );
    }

    protected function tecido(): Attribute
    {
        return Attribute::make(
            // get: fn ($value) => ucfirst($value),
            set: fn ($value) => mb_strtoupper($value),
        );
    }
}
