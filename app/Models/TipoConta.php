<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoConta extends Model
{
    use HasFactory;

    protected $table = 'tipos_contas';

    protected $fillable = [
        'nome',
    ];

    protected function nome(): Attribute
    {
        
        return Attribute::make(
            set: fn ($value) => mb_strtoupper($value),
        );
    }

    public function planosContas () {
        return $this->hasMany(PlanoConta::class, 'tipo_conta_id');
    }
}
