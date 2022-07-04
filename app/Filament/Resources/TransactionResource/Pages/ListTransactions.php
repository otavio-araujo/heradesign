<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use Closure;
use Filament\Pages\Actions;
use Filament\Tables\Filters\Layout;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\TransactionResource;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;

    protected function getActions(): array
    {
        return [
            // Actions\CreateAction::make()->visible(false),
        ];
    }

    protected function getTableRecordUrlUsing(): Closure
    {
        return fn (Model $record): string => '';
    }

    protected function getTableFiltersFormColumns(): int
    {
        return 3;
    }


}
