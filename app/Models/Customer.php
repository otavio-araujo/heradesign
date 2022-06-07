<?php

namespace App\Models;

use App\Helpers\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function parceiro()
    {
        return $this->belongsTo(Partner::class, 'partner_id', 'id');
    }

    public function tipo_pessoa(): BelongsTo
    {
        return $this->belongsTo(PersonType::class, 'person_type_id', 'id');
    }

    public function cidade(): BelongsTo
    {
        return $this->belongsTo(Cidade::class, 'cidade_id', 'id');
    }

    public function pf_customer(): HasMany
    {
        return $this->hasMany(PfCustomer::class);
    }

    public function pj_customer(): HasMany
    {
        return $this->hasMany(PjCustomer::class);
    }

    public function propostas(): HasMany
    {
        return $this->hasMany(Proposal::class);
    }


    // Mutators and Acessors

    protected function whatsapp(): Attribute
    {
        
        return Attribute::make(
            
            get: function ($value) {
                if ($value !== null) {
                    return Helpers::formataTelefone($value);
                } else {
                    return null;
                }
            },

            set: fn ($value) => Helpers::unmask_input($value),
        );
    }

    protected function telefone(): Attribute
    {
        
        return Attribute::make(
            
            get: function ($value) {
                if ($value !== null) {
                    return Helpers::formataTelefone($value);
                } else {
                    return null;
                }
            },

            set: fn ($value) => Helpers::unmask_input($value),
        );
    }

    protected function celular(): Attribute
    {
        
        return Attribute::make(
            
            get: function ($value) {
                if ($value !== null) {
                    return 
                    Helpers::formataTelefone($value);
                } else {
                    return null;
                }
            },

            set: fn ($value) => Helpers::unmask_input($value),
        );
    }
}
