<?php

namespace App\Models;

use App\Helpers\Helpers;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeedstockType extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome'
    ];

    protected $table = 'feedstock_types';

    public function feedstocks() 
    {
        return $this->hasMany(Feedstock::class);
    }

    protected function nome(): Attribute
    {
        
        return Attribute::make(

            set: fn ($value) => mb_strtoupper($value, 'UTF-8')
            
        );
    }
}
