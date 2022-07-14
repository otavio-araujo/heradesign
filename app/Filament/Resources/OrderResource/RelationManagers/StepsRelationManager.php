<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use App\Models\Step;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\DetachAction;
use Filament\Tables\Actions\DetachBulkAction;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Resources\RelationManagers\BelongsToManyRelationManager;

class StepsRelationManager extends BelongsToManyRelationManager
{
    protected static string $relationship = 'steps';

    protected static ?string $recordTitleAttribute = 'nome';

    protected static ?string $label = 'Acompanhamento';

    protected static ?string $pluralLabel = 'Acompanhamentos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                //

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // TextColumn::make('nome')
                //     ->label('Status do Pedido')
                //     ->sortable()
                // ,

                ViewColumn::make('nome')
                    ->view('filament.tables.columns.order-steps-badge')
                ,
                
                TextColumn::make('defined_at')
                    ->label('Definido em')
                    ->date('d/m/Y')
                    ->sortable()
            ])
            ->headerActions([
                // ...
                AttachAction::make()
                    ->label('Adicionar Acompanhamento')
                    ->form(fn (AttachAction $action): array => [
                        
                        $action->getRecordSelect()
                            ->label('Acompanhamentos')
                            ->required()
                        ,
                        
                        DatePicker::make('defined_at')
                            ->required()
                            ->displayFormat('d/m/Y')
                            ->label('Definido em')
                        ,
                    ])
                    ->preloadRecordSelect()
                ,
            ])
            ->actions([
                // ...
                DetachAction::make()
                    ->tooltip('Remover Acompanhamento')
                    ->label('')
                    ->color('danger')
                    ->icon('heroicon-o-trash')
                    ->size('lg')
                
                ,
            ])
            ->bulkActions([
                // ...
                DetachBulkAction::make(),
            ])
            ->filters([
                //
            ])
            ->defaultSort('defined_at', 'desc');
    }

}
