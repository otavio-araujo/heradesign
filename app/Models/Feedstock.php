<?php

namespace App\Models;

use App\Models\FeedstockSupplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feedstock extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'unidade_medida_id',
    ];

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class)->withPivot('preco', 'updated_at')->using(FeedstockSupplier::class);
    }

    public function unidade()
    {
        return $this->belongsTo(UnidadeMedida::class, 'unidade_medida_id');
    }
}
