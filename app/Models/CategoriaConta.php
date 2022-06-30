<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoriaConta extends Model
{
    use HasFactory;

    protected $table = 'categorias_contas';

    protected $fillable = [
        'nome',
        'plano_conta_id',
    ];

    protected function nome(): Attribute
    {
        
        return Attribute::make(
            set: fn ($value) => mb_strtoupper($value),
        );
    }

    public function planoContas()
    {
        return $this->belongsTo(PlanoConta::class, 'plano_conta_id');
    }
}
