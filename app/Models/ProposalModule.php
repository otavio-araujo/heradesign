<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
