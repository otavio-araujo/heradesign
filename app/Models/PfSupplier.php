<?php

namespace App\Models;

use App\Helpers\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PfSupplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'cpf',
        'supplier_id'
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    protected function cpf(): Attribute
    {
        
        return Attribute::make(
            
            get: function ($value) {
                if ($value !== null) {
                    return Helpers::formata_cpf_cnpj($value);
                } else {
                    return null;
                }
            },

            set: fn ($value) => Helpers::unmask_input($value),
        );
    }
}
