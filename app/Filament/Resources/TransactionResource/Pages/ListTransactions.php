<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use Filament\Pages\Actions;
use Filament\Tables\Filters\Layout;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\TransactionResource;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()->visible(false),
        ];
    }

    // protected function getTableFiltersLayout(): ?string
    // {
    //     return Layout::AboveContent;
    // }

}
