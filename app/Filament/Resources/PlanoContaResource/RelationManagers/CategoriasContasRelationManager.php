<?php

namespace App\Filament\Resources\PlanoContaResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoriasContasRelationManager extends RelationManager
{
    protected static string $relationship = 'categoriasContas';

    protected static ?string $recordTitleAttribute = 'nome';

    protected static ?string $label = 'Categoria de Conta';

    protected static ?string $pluralLabel = 'Categorias de Contas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')->label('Categoria da Conta'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Nova Categoria'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->tooltip('Editar Categoria')
                    ->label('')
                    ->color('warning')
                    ->icon('heroicon-o-pencil')
                    ->size('lg')
                ,
                Tables\Actions\DeleteAction::make()
                    ->tooltip('Excluir Categoria')
                    ->label('')
                    ->color('danger')
                    ->icon('heroicon-o-trash')
                    ->size('lg')
                ,
            ])
            ->bulkActions([
                Tables\Actions\DissociateBulkAction::make(),
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
