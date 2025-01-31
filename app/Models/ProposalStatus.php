<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProposalStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
    ];

    public function propostas()
    {
        return $this->hasMany(Proposal::class);
    }

    protected function nome(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => mb_strtoupper($value),
            set: fn ($value) => mb_strtoupper($value),
        );
    }
}
