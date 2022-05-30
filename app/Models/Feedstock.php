<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedstock extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'unidade_medida',
    ];

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class);
    }
}
