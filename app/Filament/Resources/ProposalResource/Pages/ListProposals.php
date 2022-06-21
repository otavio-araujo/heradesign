<?php

namespace App\Filament\Resources\ProposalResource\Pages;

use App\Models\Proposal;
use Filament\Resources\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ProposalResource;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Concerns\InteractsWithForms;

class ListProposals extends ListRecords 
{
    
    protected static string $resource = ProposalResource::class;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function statusChange(Proposal $proposal, $status_id) 
    {
        $proposal->proposal_status_id = $status_id;
        $proposal->save();

        $this->emit('refreshComponent');

        $this->notify('success', 'Status Atualizado!');
    }

}
