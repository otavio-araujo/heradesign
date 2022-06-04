<?php

namespace App\Models;

use App\Helpers\Helpers;
use App\Models\Cidade;
use App\Models\Feedstock;
use App\Models\FeedstockSupplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cnpj',
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

    public function feedstocks()
    {
        return $this->belongsToMany(Feedstock::class)->withPivot('preco', 'updated_at')->using(FeedstockSupplier::class);
    }

    public function cidade()
    {
        return $this->belongsTo(Cidade::class);
    }

    protected function cep(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Helpers::formata_cep($value),
            set: fn ($value) => Helpers::unmask_input($value),
        );
    }

    protected function cnpj(): Attribute
    {
        
        return Attribute::make(
            
            get: function ($value) {
                if ($value !== null) {
                    return Helpers::formata_cpf_cnpj($value);
                } else {
                    return null;
                }
            },

            set: fn ($value) => Helpers::unmask_input($value),
        );
    }

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
                    return Helpers::formataTelefone($value);
                } else {
                    return null;
                }
            },

            set: fn ($value) => Helpers::unmask_input($value),
        );
    }
}
