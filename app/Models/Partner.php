<?php

namespace App\Models;

use App\Models\Cidade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'contato',
        'whatsapp',
        'telefone',
        'celular',
        'email',
        'cep',
        'endereco',
        'bairro',
        'cidade_id',
        'numero',
        'complemento',
    ];

    public function cidade()
    {
        return $this->belongsTo(Cidade::class);
    }
}
