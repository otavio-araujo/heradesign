<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonType extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome'
    ];

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
