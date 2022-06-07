<?php

namespace App\Filament\Resources;

use GMP;
use Filament\Forms;
use Filament\Tables;
use App\Models\Customer;
use App\Models\Proposal;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\HasManyRepeater;
use App\Filament\Resources\ProposalResource\Pages;
use App\Filament\Resources\ProposalResource\RelationManagers;
use App\Filament\Resources\ProposalResource\Pages\EditProposal;
use App\Filament\Resources\ProposalResource\Pages\ListProposals;
use App\Filament\Resources\ProposalResource\Pages\CreateProposal;

class ProposalResource extends Resource
{
    protected static ?string $model = Proposal::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-list';

    protected static ?string $navigationGroup = 'Operacional';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?string $navigationLabel = 'Propostas';
    
    protected static ?string $slug = 'propostas';

    protected static ?string $label = 'Proposta';

    protected static ?string $pluralLabel = 'Propostas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                    Wizard::make([

                        Wizard\Step::make('Proposta')
                            ->schema([
                                
                                Grid::make([
                                    'default' => 1,
                                    'sm' => 1,
                                    'md' => 6,
                                    'lg' => 6,
                                    'xl' => 6,
                                    '2xl' => 8,
                                ])->schema([

                                    Group::make()->schema([

                                        Section::make('Dados Básicos')->schema([

                                            BelongsToSelect::make('customer_id')
                                                ->label('Cliente')
                                                ->required()
                                                ->searchable()
                                                ->relationship('cliente', 'nome')
                                                ->preload(true)
                                                ->reactive()
                                                ->afterStateHydrated(fn ($state, callable $set) => $set('cliente.parceiro.nome', Customer::find($state)?->parceiro->nome ?? ''))
                                                ->afterStateUpdated(fn ($state, callable $set) => $set('cliente.parceiro.nome', Customer::find($state)?->parceiro->nome ?? ''))
                                                ->columnSpan([
                                                    'default' => 12,
                                                    'md' => 6,
                                                ])
                                                
                                            ,
    
                                            Forms\Components\TextInput::make('cliente.parceiro.nome')
                                                ->label('Parceiro')
                                                ->disabled()
                                                ->columnSpan([
                                                    'default' => 12,
                                                    'md' => 6,
                                                ])
                                            ,
    
                                            Forms\Components\TextInput::make('largura')
                                                ->label('Largura (mm)')
                                                ->required()
                                                ->numeric()
                                                ->columnSpan([
                                                    'default' => 12,
                                                    'md' => 6,
                                                ])
                                            ,
    
                                            Forms\Components\TextInput::make('altura')
                                                ->label('Altura (mm)')
                                                ->required()
                                                ->numeric()
                                                ->columnSpan([
                                                    'default' => 12,
                                                    'md' => 6,
                                                ])
                                            ,

                                            Forms\Components\TextInput::make('preco')
                                                ->label('Valor Total da Proposta')
                                                ->numeric()
                                                ->rules(['regex:/^(\d+(\.\d{0,2})?|\.?\d{1,2})$/'])
                                                ->required()
                                                ->prefix('R$ ')
                                                ->columnSpan([
                                                    'default' => 12,
                                                    'md' => 6
                                                ])
                                            ,
    
                                            Forms\Components\TextInput::make('prazo_entrega')
                                                ->label('Prazo de Entrega (dias)')
                                                ->minValue(1)
                                                ->required()
                                                ->numeric()
                                                ->columnSpan([
                                                    'default' => 12,
                                                    'md' => 6,
                                                ])
                                            ,
    
    
                                        ])->columns(12)

                                    ])->columnSpan([
                                        'md' => 3,
                                        'lg' => 4,
                                        'xl' => 4,
                                    ]), 

                                    
    
                                    Group::make()->schema([

                                        Section::make('Status e Detalhes')->schema([ 

                                            BelongsToSelect::make('proposal_status_id')
                                                ->label('Status da Proposta')
                                                ->required()
                                                ->searchable()
                                                ->relationship('status', 'nome')
                                                ->preload(true)
                                                ->columnSpan([
                                                    'default' => 12,
                                                ])
                                                
                                            ,

                                            Forms\Components\TextInput::make('tecido')
                                                ->label('Tecido Escolhido')
                                                ->maxLength(50)
                                                ->required()
                                                ->columnSpan([
                                                    'default' => 12,
                                                ])
                                            ,

                                            Toggle::make('fita_led')
                                                ->label('Fitas de Led')
                                                ->onIcon('heroicon-s-check')
                                                ->offIcon('heroicon-s-x')
                                                ->inline(false)
                                                ->columnSpan([
                                                    'default' => 6,
                                                ])
                                            ,
    
                                            Toggle::make('separadores')
                                                ->label('Separadores em Metal')
                                                ->onIcon('heroicon-s-check')
                                                ->offIcon('heroicon-s-x')
                                                ->inline(false)
                                                ->columnSpan([
                                                    'default' => 6,
                                                ])
                                            ,

                                        ])->columns(12)

                                    ])->columnSpan([
                                        'md' => 3,
                                        'lg' => 2,

                                    ]), 

                            

                                ])

                            ]),
                        Wizard\Step::make('Módulos')
                            ->schema([

                                Grid::make([
                                    'default' => 1,
                                    'sm' => 1,
                                    'md' => 6,
                                    'lg' => 6,
                                    'xl' => 6,
                                    '2xl' => 8,
                                ])->schema([

                                    Group::make()->schema([

                                        Section::make('Configuração de Módulos')->schema([
                                
                                            HasManyRepeater::make('modulos')
                                                ->label('Módulos')
                                                ->relationship('modulos')
                                                ->schema([
                                                    
                                                    Forms\Components\TextInput::make('quantidade')
                                                        ->label('Quantidade de Módulos')
                                                        ->minValue(1)
                                                        ->required()
                                                        ->numeric()
                                                        ->columnSpan([
                                                            'default' => 12,
                                                            'md' => 3,
                                                        ])
                                                    ,

                                                    Forms\Components\TextInput::make('largura')
                                                        ->label('Largura (mm)')
                                                        ->required()
                                                        ->numeric()
                                                        ->columnSpan([
                                                            'default' => 12,
                                                            'md' => 3,
                                                        ])
                                                    ,
            
                                                    Forms\Components\TextInput::make('altura')
                                                        ->label('Altura (mm)')
                                                        ->required()
                                                        ->numeric()
                                                        ->columnSpan([
                                                            'default' => 12,
                                                            'md' => 3,
                                                        ])
                                                    ,

                                                    Forms\Components\TextInput::make('formato')
                                                        ->label('Formato do Módulo')
                                                        ->maxLength(50)
                                                        ->required()
                                                        ->columnSpan([
                                                            'default' => 12,
                                                            'md' => 3,
                                                        ])
                                                    ,

                                                ])->columns(12)

                                        ])

                                    ])->columnSpan([
                                        'md' => 3,
                                        'lg' => 6,
                                    ]), 

                                ])

                            ]),
                        Wizard\Step::make('Observações')
                            ->schema([
                                // ...
                            ]),
                    ])->columnSpan(12)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                
                Tables\Columns\TextColumn::make('preco')
                    ->label('Preço')
                    ->sortable()
                    ->money('brl'),

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
            'index' => Pages\ListProposals::route('/'),
            'create' => Pages\CreateProposal::route('/create'),
            'edit' => Pages\EditProposal::route('/{record}/edit'),
        ];
    }

}
