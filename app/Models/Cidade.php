<?php

namespace App\Models;

use App\Models\Estado;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cidade extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 'estado_id'
    ]; 

    public function estado() 
    {
        return $this->belongsTo(Estado::class);
    }

    public function suppliers() 
    {
        return $this->hasMany(Supplier::class);
    }
}
