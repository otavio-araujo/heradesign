<?php

namespace App\Filament\Resources\FeedstockResource\Pages;

use App\Helpers\Helpers;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\FeedstockResource;

class EditFeedstock extends EditRecord
{
    protected static string $resource = FeedstockResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return Helpers::arrayToUpper($data);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
