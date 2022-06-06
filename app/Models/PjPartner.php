<?php

namespace App\Models;

use App\Models\Partner;
use App\Helpers\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PjPartner extends Model
{
    use HasFactory;

    protected $fillable = [
        'cnpj',
        'inscricao_estadual',
        'inscricao_municipal',
        'partner_id'
    ];

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    protected function cnpj(): Attribute
    {
        
        return Attribute::make(
            
            get: function ($value) {
                if ($value !== null) {
                    return Helpers::formata_cpf_cnpj($value);
                } else {
                    return null;
                }
            },

            set: fn ($value) => Helpers::unmask_input($value),
        );
    }
}
