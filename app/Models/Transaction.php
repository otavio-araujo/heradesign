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
        'conta_pagar_id',
        'liquidado_em',
        'valor'
    ];

    protected $casts = [
        'conta_corrente_id' => 'integer',
        'conta_receber_id' => 'integer',
        'conta_pagar_id' => 'integer',
        'valor' => 'decimal:2',
    ];

    protected $dates = [
        'created_at',
        'updated-at',
        'liquidado_em'
    ];

    public function contaCorrente()
    {
        return $this->belongsTo(ContaCorrente::class, 'conta_corrente_id');
    }

    public function contaReceber()
    {
        return $this->belongsTo(ContaReceber::class, 'conta_receber_id');
    }

    public function contaPagar()
    {
        return $this->belongsTo(ContaPagar::class, 'conta_pagar_id');
    }
}
