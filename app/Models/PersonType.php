<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PersonType extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome'
    ];

    protected $table ='person_types';

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    public function parceiros(): HasMany
    {
        return $this->hasMany(Partner::class);
    }
}
