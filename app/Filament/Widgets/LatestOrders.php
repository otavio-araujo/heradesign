<?php

namespace App\Filament\Widgets;

use Closure;
use Filament\Tables;
use App\Models\Order;
use App\Helpers\Helpers;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{

    protected static ?int $sort = 20;

    protected static ?string $heading = 'Últimos Pedidos';

    protected int | string | array $columnSpan = 'full';


    protected function getTableQuery(): Builder
    {
        return Order::query()->latest()->limit(5);
    }

    protected function isTablePaginationEnabled(): bool 
    {
        return false;
    }

    protected function getTableRecordUrlUsing(): Closure
    {
        return fn (Model $record): string => route('filament.resources.pedidos.edit', ['record' => $record]);
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
            ,
            ViewColumn::make('valor_total')->view('filament.tables.columns.order-total-value')
        ];
    }
}
