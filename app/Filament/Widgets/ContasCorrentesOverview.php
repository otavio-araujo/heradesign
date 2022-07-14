<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Helpers\Helpers;
use App\Models\ContaPagar;
use App\Models\ContaReceber;
use App\Models\ContaCorrente;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ContasCorrentesOverview extends BaseWidget
{

    protected static ?int $sort = 5;

    protected function getCards(): array
    {
        
        $c6 = ContaCorrente::find(2);
        $caixa = ContaCorrente::find(1);
        $permuta = ContaCorrente::find(3);

        
        
        return [
            Card::make($c6->banco, Helpers::getRealCurrency($c6->saldo_atual)),
            Card::make($caixa->banco, Helpers::getRealCurrency($caixa->saldo_atual)),
            Card::make($permuta->banco, Helpers::getRealCurrency($permuta->saldo_atual)),

        ];
    }
}
