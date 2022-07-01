<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'proposal_id',
        'customer_id'
    ];

    protected $casts = [
        'proposal_id' => 'integer',
        'customer_id' => 'integer',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }

    public function steps()
    {
        return $this->belongsToMany(Step::class)->withPivot('step_id', 'defined_at')->using(OrderStep::class);
    }

    public function contasReceber ()
    {
        return $this->hasMany(ContaReceber::class);
    }
}
