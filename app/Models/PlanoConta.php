<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use PhpParser\Node\Expr\FuncCall;

class PlanoConta extends Model
{
    use HasFactory;

    protected $table = 'planos_contas';

    protected $fillable = [
        'nome',
    ];

    protected function nome(): Attribute
    {
        
        return Attribute::make(
            set: fn ($value) => mb_strtoupper($value),
        );
    }

    public function categoriasContas () 
    {
        return $this->hasMany(CategoriaConta::class, 'plano_conta_id');
    }

    public function tipoConta ()
    {
        return $this->belongsTo(TipoConta::class, 'tipo_conta_id');
    }

    public function contasReceber()
    {
        return $this->hasMany(ContaReceber::class, 'plano_conta_id');
    }
}
