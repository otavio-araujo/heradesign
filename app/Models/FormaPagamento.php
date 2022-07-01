<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormaPagamento extends Model
{
    use HasFactory;

    protected $table = 'formas_pagamentos';

    protected $fillable = [
        'nome'
    ];

    protected function nome(): Attribute
    {
        
        return Attribute::make(
            set: fn ($value) => mb_strtoupper($value),
        );
    }

    public function contasReceber()
    {
        return $this->hasMany(ContaReceber::class, 'forma_pagamento_id');
    }
}
