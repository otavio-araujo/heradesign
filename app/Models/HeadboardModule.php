<?php

namespace App\Models;

use App\Models\Headboard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HeadboardModule extends Model
{
    use HasFactory;

    protected $fillable = [
        'headboard_id',
        'formato',
        'qtd',
        'largura',
        'altura',
        'obs_module'
    ];

    protected $casts = [
        'qtd' => 'integer',
        'largura' => 'integer',
        'altura' => 'integer'
    ];

    public function headboard()
    {
        return $this->belongsTo(Headboard::class);
    }
}
