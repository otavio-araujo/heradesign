<?php

namespace App\Models;

use App\Models\Feedstock;
use App\Models\FeedstockSupplier;
use Illuminate\Database\Eloquent\Model;
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
        'cidade',
        'uf',
        'numero',
        'complemento',
    ];

    public function feedstocks()
    {
        return $this->belongsToMany(Feedstock::class)->withPivot('preco', 'updated_at')->using(FeedstockSupplier::class);
    }
}
