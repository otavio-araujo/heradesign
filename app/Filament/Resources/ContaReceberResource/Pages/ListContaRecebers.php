<?php

namespace App\Filament\Resources\ContaReceberResource\Pages;

use App\Filament\Resources\ContaReceberResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContaRecebers extends ListRecords
{
    protected static string $resource = ContaReceberResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }


    public function baixarConta() 
    {
        $this->notify('danger', 'Aqui vai baixar conta.');
    }
}
