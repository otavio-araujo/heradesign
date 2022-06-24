<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Step extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome'
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('defined_at')->using(OrderStep::class);
    }

    protected function nome(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => mb_strtoupper($value),
            set: fn ($value) => mb_strtoupper($value),
        );
    }
}
