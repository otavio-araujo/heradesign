<?php

namespace App\Filament\Resources\FeedstockTypeResource\Pages;

use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\FeedstockTypeResource;

class ListFeedstockTypes extends ListRecords
{
    protected static string $resource = FeedstockTypeResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make()->label('Novo Tipo de Matéria Prima'),
        ];
    }
}
