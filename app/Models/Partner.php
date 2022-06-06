<?php

namespace App\Models;

use App\Models\Cidade;
use App\Models\PfPartner;
use App\Models\PjPartner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'person_type_id',
    ];

    public function cidade()
    {
        return $this->belongsTo(Cidade::class);
    }

    public function pf_partner(): HasMany
    {
        return $this->hasMany(PfPartner::class);
    }

    public function pj_partner(): HasMany
    {
        return $this->hasMany(PjPartner::class);
    }
}
