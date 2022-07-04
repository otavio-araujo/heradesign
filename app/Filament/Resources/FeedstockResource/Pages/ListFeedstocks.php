<?php

namespace App\Filament\Resources\FeedstockResource\Pages;

use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\FeedstockResource;

class ListFeedstocks extends ListRecords
{
    protected static string $resource = FeedstockResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make()->label('Nova Matéria Prima'),
        ];
    }
}
