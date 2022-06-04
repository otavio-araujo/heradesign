<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UnidadeMedidaResource\Pages;
use App\Filament\Resources\UnidadeMedidaResource\RelationManagers;
use App\Models\UnidadeMedida;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class UnidadeMedidaResource extends Resource
{
    protected static ?string $model = UnidadeMedida::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

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
                //
            ])
            ->filters([
                //
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUnidadeMedidas::route('/'),
            'create' => Pages\CreateUnidadeMedida::route('/create'),
            'edit' => Pages\EditUnidadeMedida::route('/{record}/edit'),
        ];
    }
}
