<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Helpers\Helpers;
use App\Models\ContaPagar;
use App\Models\ContaReceber;
use App\Models\ContaCorrente;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ReceitasDespesasOverview extends BaseWidget
{

    protected static ?int $sort = 6;

    protected function getCards(): array
    {
        
        $receitas = ContaReceber::whereMonth('vencimento_em', Carbon::now()->format('m'))
                                ->whereYear('vencimento_em', Carbon::now()->format('Y'))
                                ->sum('valor_previsto');

        $receitas_realizadas = ContaReceber::whereMonth('liquidado_em', Carbon::now()->format('m'))
                                ->whereYear('liquidado_em', Carbon::now()->format('Y'))
                                ->sum('valor_previsto');

        $despesas = ContaPagar::whereMonth('vencimento_em', Carbon::now()->format('m'))
                                ->whereYear('vencimento_em', Carbon::now()->format('Y'))
                                ->sum('valor_previsto');

        $despesas_realizadas = ContaPagar::whereMonth('liquidado_em', Carbon::now()->format('m'))
                                ->whereYear('liquidado_em', Carbon::now()->format('Y'))
                                ->sum('valor_previsto');

        
        
        return [
            Card::make('Previsão de Receitas', Helpers::getRealCurrency($receitas)),
            Card::make('Receitas Realizadas', Helpers::getRealCurrency($receitas_realizadas)),
            Card::make('Previsão de Despesas', Helpers::getRealCurrency($despesas)),
            Card::make('Despesas Realizadas', Helpers::getRealCurrency($despesas_realizadas)),

        ];
    }
}
