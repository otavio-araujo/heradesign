<?php

namespace App\Filament\Resources\FeedstockTypeResource\Pages;

use App\Filament\Resources\FeedstockTypeResource;
use Filament\Resources\Pages\EditRecord;

class EditFeedstockType extends EditRecord
{
    protected static string $resource = FeedstockTypeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
