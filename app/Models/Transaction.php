<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'conta_corrente_id',
        'conta_receber_id',
        'saldo_anterior',
        'saldo_atual',
        'valor'
    ];

    protected $casts = [
        'conta_corrente_id' => 'integer',
        'conta_receber_id' => 'integer',
        'saldo_anterior' => 'decimal:2',
        'saldo_atual' => 'decimal:2',
        'valor' => 'decimal:2',
    ];

    public function contaCorrente()
    {
        return $this->belongsTo(ContaCorrente::class, 'conta_corrente_id');
    }

    public function contaReceber()
    {
        return $this->belongsTo(ContaReceber::class, 'conta_receber_id');
    }
}
