<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Helpers\Helpers;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\OrderResource;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['id'] = Helpers::setProposalNumber($data['id']);
        $data['proposal_id'] = Helpers::setProposalNumber($data['proposal_id']);
    
        return $data;
    }

    protected function getActions(): array
    {
        return [
            DeleteAction::make()
        ];
    }
 
    public function voltar()
    {
        return redirect()->route('filament.resources.pedidos.index');
    }

    protected function getFormActions(): array
    {
        return array_merge([
            Action::make('voltar')->action('voltar')->color('secondary'),
        ]);
    }

}
