<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\PlanoConta;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PlanoContaResource\Pages;
use App\Filament\Resources\PlanoContaResource\RelationManagers;
use App\Filament\Resources\PlanoContaResource\RelationManagers\CategoriasContasRelationManager;

class PlanoContaResource extends Resource
{
    protected static ?string $model = PlanoConta::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark-alt';

    protected static ?string $navigationGroup = 'Financeiro';

    protected static ?int $navigationSort = 11;

    protected static ?string $recordTitleAttribute = 'nome';

    protected static ?string $navigationLabel = 'Planos de Contas';
    
    protected static ?string $slug = 'planos-de-contas';

    protected static ?string $label = 'Plano de Conta';

    protected static ?string $pluralLabel = 'Planos de Contas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                Grid::make([
                    'default' => 1,
                    'sm' => 2,
                    'md' => 3,
                    'lg' => 4,
                    'xl' => 6,
                    '2xl' => 8,
                ])->schema([
    
                    Section::make('Dados Básicos')->schema([

                        Select::make('tipo_conta_id')
                            ->relationship('tipoConta', 'nome')
                            ->required()
                            ->preload(true)
                            ->columnSpan(12)
                        ,
                        
                        TextInput::make('nome')
                            ->autofocus()    
                            ->label('Nome do Plano de Conta')
                            ->unique(PlanoConta::class, 'nome', fn ($record) => $record)
                            ->required()
                            ->columnSpan(12)
                        ,
    
    
                    ])->columnSpan([
                            'md' => 2,
                            'lg' => 3,
                            'xl' => 4,
                        ])
                        ->columns(12)
                    ,
    
                    Section::make('Alterações')->schema([
    
                        Placeholder::make('created_at')
                            ->label('Data do cadastro')
                            ->content(fn (?PlanoConta $record): string => $record ? $record->created_at->diffForHumans() : '-'),
    
                        Placeholder::make('updated_at')
                            ->label('Última atualização')
                            ->content(fn (?PlanoConta $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
    
                    ])->columnSpan([
                        'md' => 1,
                        'xl' => 2,
                    ]),
    
                ])

            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nome')->label('Plano de Conta'),
                ViewColumn::make('tipoConta.nome')->view('filament.tables.columns.tipos-contas'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->tooltip('Editar Plano de Conta')
                    ->label('')
                    ->color('warning')
                    ->icon('heroicon-o-pencil')
                    ->size('lg'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            CategoriasContasRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlanoContas::route('/'),
            'create' => Pages\CreatePlanoConta::route('/create'),
            'edit' => Pages\EditPlanoConta::route('/{record}/edit'),
        ];
    }    
}
