<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use App\Models\UnidadeMedida;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\UnidadeMedidaResource\Pages;
use App\Filament\Resources\UnidadeMedidaResource\RelationManagers;

class UnidadeMedidaResource extends Resource
{
    protected static ?string $model = UnidadeMedida::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Cadastros Auxiliares';

    protected static ?int $navigationSort = 103;

    protected static ?string $recordTitleAttribute = 'nome';

    protected static ?string $navigationLabel = 'Unidades de Medidas';
    
    protected static ?string $slug = 'unidades-de-medidas';

    protected static ?string $label = 'Unidade de Medida';

    protected static ?string $pluralLabel = 'Unidades de Medidas';

    public static function form(Form $form): Form
    {
        return $form->schema([

            Grid::make([
                'default' => 1,
                'sm' => 2,
                'md' => 3,
                'lg' => 4,
                'xl' => 6,
                '2xl' => 8,
            ])->schema([

                Section::make('Dados Básicos')->schema([
                    
                    TextInput::make('nome')
                        ->autofocus()
                        ->label('Unidade de Medida')
                        ->required()
                        ->unique(UnidadeMedida::class, 'nome', fn ($record) => $record)
                        ->maxLength(50)
                        ->columnSpan([
                            'md' => 3,
                        ])
                    ,

                    TextInput::make('simbolo')
                        ->label('Símbolo')
                        ->required()
                        ->unique(UnidadeMedida::class, 'simbolo', fn ($record) => $record)
                        ->maxLength(15)
                        ->columnSpan([
                            'md' => 1,
                        ])
                    ,

                ])->columnSpan([
                        'md' => 2,
                        'lg' => 3,
                        'xl' => 4,
                    ])->columns([
                            'md' => 4,
                        ]),

                Section::make('Alterações')->schema([

                    Forms\Components\Placeholder::make('created_at')
                        ->label('Data do cadastro')
                        ->content(fn (?UnidadeMedida $record): string => $record ? $record->created_at->diffForHumans() : '-'),

                    Forms\Components\Placeholder::make('updated_at')
                        ->label('Última atualização')
                        ->content(fn (?UnidadeMedida $record): string => $record ? $record->updated_at->diffForHumans() : '-'),

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

            TextColumn::make('nome')
                ->label('Unidade de Medida')
                ->searchable()
                ->sortable(),

            TextColumn::make('simbolo')
                ->label('Símbolo')
                ->searchable()
                ->sortable(),
                
            ])
            ->defaultSort('nome');
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

    public static function getGloballySearchableAttributes(): array
    {
        return ['nome', 'simbolo'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        
        
        return [
            'Unidade de Medida' => $record->nome,
            'Símbolo' => $record->simbolo,
        ];
    }
}
