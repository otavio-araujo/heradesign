<?php

namespace App\Filament\Resources\FeedstockResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\BelongsToManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class SuppliersRelationManager extends BelongsToManyRelationManager
{
    protected static string $relationship = 'suppliers';

    protected static ?string $recordTitleAttribute = 'nome';

    protected static ?string $label = 'Fornecedor';

    protected static ?string $pluralLabel = 'Fornecedores';

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
                Tables\Columns\TextColumn::make('nome'),
                Tables\Columns\TextColumn::make('contato'),
                Tables\Columns\TextColumn::make('telefone'),
                Tables\Columns\TextColumn::make('celular'),
                Tables\Columns\TextColumn::make('whatsapp'),
            ])
            ->filters([
                //
            ]);
    }
}
