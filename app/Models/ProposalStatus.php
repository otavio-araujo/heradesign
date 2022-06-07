<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
