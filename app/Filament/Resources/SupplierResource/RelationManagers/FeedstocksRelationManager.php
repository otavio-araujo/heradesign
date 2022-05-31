<?php

namespace App\Filament\Resources\SupplierResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\BelongsToManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class FeedstocksRelationManager extends BelongsToManyRelationManager
{
    protected static string $relationship = 'feedstocks';

    protected static ?string $recordTitleAttribute = 'nome';

    protected static ?string $label = 'Matéria Prima';

    protected static ?string $pluralLabel = 'Matérias Primas';

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
                Tables\Columns\TextColumn::make('nome')
                    ->label('Produto')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('unidade_medida')
                    ->label('Unidade de Medida')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('preco')
                    ->label('Preço')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Última Cotação')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ]);
    }
}