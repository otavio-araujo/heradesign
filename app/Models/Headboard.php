<?php

namespace App\Models;

use App\Models\Proposal;
use App\Models\HeadboardModule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Headboard extends Model
{
    use HasFactory;

    protected $fillable = [
        'largura',
        'altura',
        'qtd',
        'valor_unitario',
        'tecido',
        'has_led',
        'obs_led',
        'has_separador',
        'obs_separador',
        'has_tomada',
        'obs_tomada',
        'qtd_tomada',
        'obs_headboard', 
        'valor_total'
    ];


    protected $casts = [
        'has_led' => 'boolean',
        'has_separador' => 'boolean',
        'has_tomada' => 'boolean',
        'largura' => 'integer',
        'altura' => 'integer',
        'qtd_tomada' => 'integer',
        'qtd' => 'integer',
        'valor_unitario' => 'decimal: 2',
        'valor_total' => 'decimal: 2'
    ];

    // RELACIONAMENTOS

    public function modules()
    {
        return $this->hasMany(HeadboardModule::class);
    }

    public function proposal ()
    {
        return $this->belongsTo(Proposal::class);
    }

    //MUTATOS E ACCESSORS

    protected function valorTotal(): Attribute
    {
        return Attribute::make(
            // get: fn ($value) => number_format($value, 2, ',', '.'),
            set: fn ($value, $attributes) => $attributes['qtd'] * $attributes['valor_unitario'],
        );
    }
}
