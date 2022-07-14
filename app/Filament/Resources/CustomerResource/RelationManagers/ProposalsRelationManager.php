<?php

namespace App\Filament\Resources\CustomerResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Models\Proposal;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Resources\RelationManagers\HasManyRelationManager;

class ProposalsRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'proposals';

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?string $label = 'Proposta';

    protected static ?string $pluralLabel = 'Propostas';

    protected $listeners = ['refreshComponent' => '$refresh'];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('id')
                    ->label('#')
                    ->sortable()
                ,

                Tables\Columns\TextColumn::make('customer.parceiro.nome')
                    ->label('Parceiro')
                    ->sortable()
                ,

                ViewColumn::make('status')
                    ->view('filament.tables.columns.proposal-status')
                    ->url(null)
                ,

                ViewColumn::make('valor_total')->view('filament.tables.columns.proposal-valor-total'),

            ])
            ->headerActions([

            ])
            ->actions([

                    Action::make('poropsal_print')
                        ->tooltip('Imprimir Proposta')
                        ->label('')
                        ->url(fn (Proposal $record): string => route('proposal.pdf', $record))
                        ->openUrlInNewTab()
                        ->color('secondary')
                        ->icon('heroicon-o-printer')
                        ->size('lg')
                    ,
                    Action::make('order_generate')
                        ->label('')
                        ->tooltip('Gerar Pedido')
                        ->color('success')
                        ->icon('heroicon-o-clipboard-check')
                        ->size('lg')
                        ->action('generateOrder', fn (Proposal $record): string => $record->id)
                    ,
    
                    Action::make('edit')
                        ->tooltip('Editar Proposta')
                        ->label('')
                        ->color('warning')
                        ->icon('heroicon-o-pencil')
                        ->size('lg')
                        ->openUrlInNewTab()
                        ->url(fn (Proposal $record): string => route('filament.resources.propostas.edit', $record))
                    , 
                
            ])
            ->defaultSort('id', 'desc');
            ;
    }

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
            
            return redirect()->route('filament.resources.pedidos.edit', $order->id);

        } else {

            $dados = [
                'proposal_id' => $record->id,
                'customer_id' => $record->customer->id
            ];

            $order = Order::create($dados);

            $this->notify('success', 'Pedido Gerado com Sucesso!');

            return redirect()->route('filament.resources.pedidos.edit', $order);
            
        }
        
        
        return $record;
    }
}
