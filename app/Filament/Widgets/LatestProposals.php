<?php

namespace App\Filament\Widgets;

use Closure;
use App\Helpers\Helpers;
use App\Models\Proposal;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestProposals extends BaseWidget
{

    protected static ?int $sort = 10;

    protected static ?string $heading = 'Últimas Propostas';

    protected int | string | array $columnSpan = 'full';


    protected function getTableQuery(): Builder
    {
        return Proposal::query()->latest()->limit(5);
    }

    protected function isTablePaginationEnabled(): bool 
    {
        return false;
    }

    protected function getTableRecordUrlUsing(): Closure
    {
        return fn (Model $record): string => route('filament.resources.propostas.edit', ['record' => $record]);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('id')
                ->label('Pedido Nº')
                ->formatStateUsing(fn (string $state): string => __(Helpers::setProposalNumber($state)))
            ,
            
            TextColumn::make('customer.nome')
                ->label('Cliente')
                ->wrap()
            ,
            ViewColumn::make('valor_total')->view('filament.tables.columns.proposal-valor-total')
        ];
    }
}
