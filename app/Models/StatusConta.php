<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StatusConta extends Model
{
    use HasFactory;

    protected $table = 'status_contas';

    protected $fillable = [
        'nome'
    ];

    public function contasReceber()
    {
        return $this->hasMany(ContaReceber::class, 'status_conta_id');
    }


    protected function nome(): Attribute
    {
        
        return Attribute::make(
            set: fn ($value) => mb_strtoupper($value),
        );
    }
}
