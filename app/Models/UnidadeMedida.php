<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadeMedida extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'simbolo',
    ];
    protected $table = 'unidade_medidas';

    public function feedstocks()
    {
        return $this->hasMany(Feedstock::class);
    }
}
