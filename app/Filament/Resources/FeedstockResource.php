<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Feedstock;
use Filament\Resources\Form;
use App\Models\FeedstockType;
use App\Models\UnidadeMedida;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\BelongsToSelect;
use App\Filament\Resources\FeedstockResource\Pages;
use App\Filament\Resources\FeedstockResource\RelationManagers;

class FeedstockResource extends Resource
{
    protected static ?string $model = Feedstock::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Fornecedores e Materiais';

    protected static ?int $navigationSort = 99;

    protected static ?string $recordTitleAttribute = 'nome';

    protected static ?string $navigationLabel = 'Matérias Primas';
    
    protected static ?string $slug = 'materias-primas';

    protected static ?string $label = 'Matéria Prima';

    protected static ?string $pluralLabel = 'Matérias Primas';


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

                Section::make('Matéria Prima')->schema([
                    
                    /* Select::make('feedstock_type_id')
                        ->autofocus()
                        ->label('Tipo')
                        ->required()
                        ->options(FeedstockType::all()->sortBy('nome')->pluck('nome', 'id'))
                        ->searchable()
                    , */

                    BelongsToSelect::make('feedstock_type_id')
                        ->label('Tipo de Matéria Prima')
                        ->searchable()
                        ->relationship('feedstock_type', 'nome')
                        ->createOptionForm([
                            Grid::make([
                                'default' => 1,
                                'sm' => 2,
                                'md' => 3,
                                'lg' => 4,
                                'xl' => 6,
                                '2xl' => 8,
                            ])->schema([
                
                                Section::make('Dados Básicos')->schema([
                                    
                                    Forms\Components\TextInput::make('nome')
                                        ->autofocus()
                                        ->label('Nome')
                                        ->required()
                                        ->unique(FeedstockType::class, 'nome', fn ($record) => $record)
                                        ->maxLength(100)
                                        ->columnSpan([
                                            'default' => 12,
                                        ])
                                    ,
                
                                ])->columnSpan([
                                        'md' => 3,
                                        'lg' => 4,
                                        'xl' => 8,
                                    ])->columns([
                                            'md' => 12,
                                        ]),
                
                            ]),
                        ])
                        ->createOptionAction(fn ($action) => $action->modalHeading('Cadastrar Novo Tipo de  Matéria Prima'))
                        ->preload(true)
                        
                    ,
                    
                    Forms\Components\TextInput::make('nome')
                        ->required()
                        ->unique(Feedstock::class, 'nome', fn($record) => $record)
                        ->maxLength(150)
                    ,

                    Select::make('unidade_medida_id')
                        ->label('Unidade de Medida')
                        ->required()
                        ->options(UnidadeMedida::all()->sortBy('nome')->pluck('nome', 'id'))
                        ->searchable()
                    ,

                ])->columnSpan([
                    'md' => 2,
                    'lg' => 3,
                    'xl' => 4,
                ]),

                Section::make('Alterações')->schema([

                    Forms\Components\Placeholder::make('created_at')
                        ->label('Data do cadastro')
                        ->content(fn (?Feedstock $record): string => $record ? $record->created_at->diffForHumans() : '-'),

                    Forms\Components\Placeholder::make('updated_at')
                        ->label('Última atualização')
                        ->content(fn (?Feedstock $record): string => $record ? $record->updated_at->diffForHumans() : '-'),

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
            ->columns(static::getTableColumns())
            ->filters([
                
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            RelationManagers\SuppliersRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFeedstocks::route('/'),
            'create' => Pages\CreateFeedstock::route('/create'),
            'edit' => Pages\EditFeedstock::route('/{record}/edit'),
        ];
    }

    public static function getTableColumns(): array
    {
        return [

            Tables\Columns\TextColumn::make('feedstock_type.nome')
                ->label('Tipo')
                ->searchable()
                ->sortable(),
            
            Tables\Columns\TextColumn::make('nome')
                ->label('Produto')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('unidade.simbolo')
                ->label('Unidade de Medida')
                ->searchable()
                ->sortable(),
                
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['nome'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        
        
        return [
            'Tipo' => $record->feedstock_type->nome,
            'Nome' => $record->nome,
            'Un. Medida' => $record->unidade->simbolo,
        ];
    }
}
