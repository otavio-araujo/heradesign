<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\Headboard;
use App\Models\ProposalItem;
use App\Models\ProposalStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'proposal_status_id',
        'customer_id',
        'prazo_entrega',
        'pgto_vista',
        'pgto_cartao',
        'pgto_boleto',
        'pgto_outros',
        'validade',
        'desconto',
        'obs_proposal'
    ];

    protected $casts = [
        'validade' => 'integer',
        'prazo_entrega' => 'integer',
    ];


    public function status ()
    {
        return $this->belongsTo(ProposalStatus::class, 'proposal_status_id');
    }

    public function customer ()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function headboards ()
    {
        return $this->hasMany(Headboard::class);
    }

    public function proposalItems ()
    {
        return $this->hasMany(ProposalItem::class);
    }

    
}
