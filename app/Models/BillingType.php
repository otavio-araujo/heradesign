<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingType extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
    ];


    public function receivables ()
    {
        return $this->hasMany(Receivable::class);
    }
}
