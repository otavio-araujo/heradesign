<?php

namespace App\Models;

use App\Models\Estado;
use App\Models\Partner;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cidade extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 'estado_id'
    ]; 

    protected $table = 'cidades';

    public function estado(): BelongsTo
    {
        return $this->belongsTo(Estado::class);
    }

    public function suppliers(): HasMany
    {
        return $this->hasMany(Supplier::class);
    }

    public function partners(): HasMany
    {
        return $this->hasMany(Partner::class);
    }

    public function clientes(): HasMany
    {
        return $this->hasMany(Customer::class);
    }
}
