<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'nome_fantasia',
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
        'person_type_id',
        'partner_id',
    ];

    public function tipo_pessoa()
    {
        return $this->belongsTo(PersonType::class);
    }
}
