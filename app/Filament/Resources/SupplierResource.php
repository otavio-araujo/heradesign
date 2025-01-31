<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use Filament\Tables;
use App\Models\Cidade;
use App\Models\Estado;
use App\Helpers\Helpers;
use App\Models\Supplier;
use App\Models\PersonType;
use App\Models\PfSupplier;
use App\Models\PjSupplier;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\SupplierResource\Pages;
use App\Filament\Resources\SupplierResource\RelationManagers;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'Fornecedores e Materiais';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'nome';

    protected static ?string $navigationLabel = 'Fornecedores';
    
    protected static ?string $slug = 'fornecedores';

    protected static ?string $label = 'Fornecedor';

    protected static ?string $pluralLabel = 'Fornecedores';

    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Grid::make([
                        'default' => 1,
                        'sm' => 1,
                        'md' => 3,
                        'lg' => 4,
                        'xl' => 6,
                        '2xl' => 8,
                    ])->schema([

                    Group::make()->schema([

                        Section::make('Dados Cadastrais')->schema([
    
                            Group::make()->schema([

                                Select::make('person_type_id')
                                    ->label('Tipo de Pessoa')
                                    ->required()
                                    ->options(PersonType::all()->pluck('nome', 'id'))
                                    ->searchable()
                                    ->reactive()
                                    ->columnSpan([
                                        'default' => 12,
                                        'md' => 6,
                                    ])
                                ,

                                Forms\Components\TextInput::make('cpf')
                                    ->unique(PfSupplier::class, 'cpf', fn ($record) => $record)
                                    ->label('CPF')
                                    ->rules('cpf')
                                    ->mask(fn (TextInput\Mask $mask) => $mask->pattern('000.000.000-00'))
                                    ->maxLength(15)
                                    ->columnSpan([
                                        'default' => 12,
                                        'md' => 6, 
                                    ])->visible(fn (Closure $get) => ($get('person_type_id') == 1))
                                ,

                                Forms\Components\TextInput::make('cnpj')
                                    ->unique(PjSupplier::class, 'cnpj', fn ($record) => $record)
                                    ->label('CNPJ')
                                    ->rules('cnpj')
                                    ->mask(fn (TextInput\Mask $mask) => $mask->pattern('00.000.000/0000-00'))
                                    ->maxLength(18)
                                    ->columnSpan([
                                        'default' => 12,
                                        'md' => 6, 
                                    ])->visible(fn (Closure $get) => ($get('person_type_id') == 2   ))
                                ,

                                Forms\Components\TextInput::make('inscricao_estadual')
                                    ->label('Inscrição Estadual')
                                    ->rules('numeric')
                                    ->hydrateDefaultState()
                                    ->columnSpan([
                                        'default' => 12,
                                        'md' => 6, 
                                    ])->visible(fn (Closure $get) => ($get('person_type_id') == 2   ))
                                ,

                                Forms\Components\TextInput::make('inscricao_municipal')
                                    ->label('Inscrição Municipal')
                                    ->rules('numeric')
                                    ->mask(fn (TextInput\Mask $mask) => $mask->pattern('000000000000000'))
                                    ->columnSpan([
                                        'default' => 12,
                                        'md' => 6, 
                                    ])->visible(fn (Closure $get) => ($get('person_type_id') == 2   ))
                                ,

                            ])->columnSpan(12)->columns([
                                                    'default' => 12,
                                                    'md' => 12,
                                                ]),  

                            Group::make()->schema([ 

                                Forms\Components\TextInput::make('nome')
                                    ->required()
                                    ->unique(Supplier::class, 'nome', fn ($record) => $record)
                                    ->maxLength(150)
                                    ->columnSpan([
                                        'default' => 12,
                                        'md' => 6, 
                                    ])
                                ,

                                Forms\Components\TextInput::make('nome_fantasia')
                                    ->maxLength(150)
                                    ->columnSpan([
                                        'default' => 12,
                                        'md' => 6, 
                                    ])
                                ,

                            ])->columnSpan(12)
                                ->columns([
                                    'default' => 12,
                                    'md' => 12,
                                ]), 
    
                        ])->columns([
                                'md' => 12
                            ]),
        
                        Section::make('Correspondência')->schema([
    
                            Forms\Components\TextInput::make('cep')
                                ->maxLength(9)
                                ->mask(fn (TextInput\Mask $mask) => $mask->pattern('00000-000'))
                                ->columnSpan([
                                    'default' => 12,
                                    'md' => 3,
                                ])
                            ,

                            Forms\Components\TextInput::make('endereco')
                                ->maxLength(255)
                                ->columnSpan([
                                    'default' => 12,
                                    'md' => 9,
                                ])
                            ,

                            Forms\Components\TextInput::make('bairro')
                                ->maxLength(150)
                                ->columnSpan([
                                    'default' => 12,
                                    'md' => 5,
                                ])
                            ,

                            Select::make('cidade_id')
                                ->label('Cidade')
                                ->required()
                                ->searchable()
                                ->options(Cidade::all()->pluck('nome', 'id'))
                                // ->getSearchResultsUsing(fn (string $searchQuery) => Cidade::where('nome', 'like', "%{$searchQuery}%")->limit(50)->pluck('nome', 'id'))
                                // ->getOptionLabelUsing(fn ($value): ?string => Cidade::find($value)?->nome)
                                ->reactive()
                                ->afterStateHydrated(fn ($state, callable $set) => $set('uf', Cidade::find($state)?->estado->uf ?? ''))
                                ->afterStateUpdated(fn ($state, callable $set) => $set('uf', Cidade::find($state)?->estado->uf ?? ''))
                                ->columnSpan([
                                    'default' => 12,
                                    'md' => 5,
                                ])
                            ,

                            Forms\Components\TextInput::make('uf')
                                ->disabled()
                                ->maxLength(2)
                                ->columnSpan([
                                    'default' => 12,
                                    'md' => 2,
                                ])
                            ,                 
                        
                            Forms\Components\TextInput::make('numero')
                                ->maxLength(10)
                                ->mask(fn (TextInput\Mask $mask) => $mask->pattern('0000000000'))
                                ->columnSpan([
                                    'default' => 12,
                                    'md' => 5,
                                ])
                            ,

                            Forms\Components\TextInput::make('complemento')
                                ->maxLength(100)
                                ->columnSpan([
                                    'default' => 12,
                                    'md' => 7,
                                ])
                            ,
    
                        ])->columns([
                                'md' => 12
                            ]),
    
                    ])->columnSpan([
                            'md' => 2,
                            'lg' => 3,
                            'xl' => 4,
                         ]),

                    Group::make()->schema([

                        Section::make('Contatos')->schema([
    
                            Forms\Components\TextInput::make('contato')
                                ->label('Contato')
                                ->maxLength(150)
                                ->columnSpan([
                                    'default' => 12,
                                ])
                            ,
                            
                            Forms\Components\TextInput::make('whatsapp')
                                ->maxLength(15)
                                ->mask(fn (TextInput\Mask $mask) => $mask->pattern('(00) 00000-0000'))
                                ->columnSpan([
                                    'default' => 12,
                                ])
                            ,

                            Forms\Components\TextInput::make('telefone')
                                ->maxLength(15)
                                ->mask(fn (TextInput\Mask $mask) => $mask->pattern('(00) 0000-0000'))
                                ->columnSpan([
                                    'default' => 12,
                                ])
                            ,

                            Forms\Components\TextInput::make('celular')
                                ->maxLength(15)
                                ->mask(fn (TextInput\Mask $mask) => $mask->pattern('(00) 00000-0000'))
                                ->columnSpan([
                                    'default' => 12,
                                ])
                            ,

                            Forms\Components\TextInput::make('email')
                                ->email()
                                ->maxLength(255)
                                ->columnSpan(12)
                            ,
    
                        ]),
    
                    ])->columnSpan([
                            'md' => 1,
                            'xl' => 2,
                        ]),

                ]),

                
            ]);
    }


    public static function table(Table $table): Table
    {
        
        return $table
            ->columns([

                    Tables\Columns\TextColumn::make('nome')
                        ->sortable()
                        ->searchable()
                    ,

                    Tables\Columns\TextColumn::make('contato')
                        ->sortable()
                        ->searchable()
                    ,

                    ViewColumn::make('cpf_cnpj')
                        ->view('filament.tables.columns.cpf-cnpj')
                        ->label('CPF/CNPJ')
                    ,

                    TextColumn::make('telefones')
                        ->view('filament.tables.columns.telefones')
                        ->label('Telefones')
                    ,
                    
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->tooltip('Editar Fornecedor')
                    ->label('')
                    ->icon('heroicon-o-pencil')
                    ->size('lg'),
            ])
        ;
    }
    
    public static function getRelations(): array
    {
        return [
            RelationManagers\FeedstocksRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),
            'edit' => Pages\EditSupplier::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['nome', 'cidade.nome', 'contato'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        
        
        return [
            'Contato' => $record->contato,
            'Whatsapp' => Helpers::formataTelefone($record->whatsapp),
        ];
    }

}
