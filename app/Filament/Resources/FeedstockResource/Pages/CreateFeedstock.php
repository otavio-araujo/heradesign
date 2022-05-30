<?php

namespace App\Filament\Resources\FeedstockResource\Pages;

use App\Helpers\Helpers;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\FeedstockResource;

class CreateFeedstock extends CreateRecord
{
    protected static string $resource = FeedstockResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return Helpers::arrayToUpper($data);
    }

}
