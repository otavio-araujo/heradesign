<?php

namespace App\Filament\Resources\EstadoResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class CidadesRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'cidades';

    protected static ?string $recordTitleAttribute = 'nome';

    protected static ?string $label = 'Cidade';

    protected static ?string $pluralLabel = 'Cidades';

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
                ->label('Nome da Cidade')
                ->searchable()
                ->sortable(),

                Tables\Columns\TextColumn::make('estado.uf')
                    ->label('UF')
                    ->searchable()
                    ->sortable(),
            ])

            ->filters([
                //
            ]);
    }

    /* public static function attachForm(Form $form): Form
    {
        return $form
            ->schema([
                static::getAttachFormRecordSelect()
                    ->required()
                    ->label('Nome da Cidade'),
            ]);
    } */
}
