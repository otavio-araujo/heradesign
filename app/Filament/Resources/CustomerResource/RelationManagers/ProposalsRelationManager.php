<?php

namespace App\Filament\Resources\CustomerResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Proposal;
use Filament\Resources\Form;
use Filament\Resources\Table;
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
                
                // Tables\Columns\TextColumn::make('valor_total')
                //     ->label('Valor Total')
                //     ->sortable()
                //     ->money('brl'),

            ])
            ->headerActions([

            ])
            ->actions([
                Action::make('Imprimir')
                        ->url(fn (Proposal $record): string => route('proposal.pdf', $record))
                        ->openUrlInNewTab()
                        ->color('secondary')
                        ->icon('heroicon-o-printer')
                ,
                Action::make('Alterar')
                        ->url(fn (Proposal $record): string => route('filament.resources.propostas.edit', $record))
                        ->openUrlInNewTab()
                        ->icon('heroicon-o-pencil')
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
}
