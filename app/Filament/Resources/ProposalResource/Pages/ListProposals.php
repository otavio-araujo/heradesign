<?php

namespace App\Filament\Resources\ProposalResource\Pages;

use App\Models\Order;
use App\Models\Proposal;
use Filament\Resources\Form;
use Illuminate\Support\Facades\DB;
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

    public function generateOrder (Proposal $record)
    {
        
        if ($counter = Order::where('proposal_id', $record->id)->count()) {

            $this->notify('warning', 'Pedido Já Existente');

            $order = DB::table('orders')
                                ->where('proposal_id', $record->id)->first();
            
            return redirect()->route('filament.resources.orders.edit', $order->id);

        } else {

            $dados = [
                'proposal_id' => $record->id,
                'customer_id' => $record->customer->id
            ];

            $order = Order::create($dados);

            $this->notify('success', 'Pedido Gerado com Sucesso!');

            return redirect()->route('filament.resources.orders.edit', $order);
            
        }
        
        
        return $record;
    }

}
