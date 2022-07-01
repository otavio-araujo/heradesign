<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContaCorrente extends Model
{
    use HasFactory;

    protected $table = 'contas_correntes';

    protected $fillable = [
        'titular',
        'banco',
        'agencia',
        'conta',
        'saldo_inicial',
        'saldo_atual'
    ];

    protected $casts = [
        'saldo_inicial' => 'decimal:2',
        'saldo_atual' => 'decimal:2',
    ];

    /*Relationships*/

    public function contasReceber()
    {
        return $this->hasMany(ContaReceber::class, 'conta_corrente_id');
    }

    /*Mutators and Accessors */

    protected function titular(): Attribute
    {
        
        return Attribute::make(
            set: fn ($value) => mb_strtoupper($value),
        );
    }

    protected function banco(): Attribute
    {
        
        return Attribute::make(
            set: fn ($value) => mb_strtoupper($value),
        );
    }

    protected function agencia(): Attribute
    {
        
        return Attribute::make(
            set: fn ($value) => mb_strtoupper($value),
        );
    }

    protected function conta(): Attribute
    {
        
        return Attribute::make(
            set: fn ($value) => mb_strtoupper($value),
        );
    }
}
