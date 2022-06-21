<?php

namespace App\Filament\Resources;

use GMP;
use Closure;
use Filament\Forms;
use Filament\Tables;
use App\Models\Customer;
use App\Models\Proposal;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\ViewColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput\Mask;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\HasManyRepeater;
use App\Filament\Resources\ProposalResource\Pages;
use App\Filament\Resources\ProposalResource\RelationManagers;
use App\Filament\Resources\ProposalResource\Pages\EditProposal;
use App\Filament\Resources\ProposalResource\Pages\ListProposals;
use App\Filament\Resources\ProposalResource\Pages\CreateProposal;
use App\Tables\Columns\StatusSwitcher;

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

    protected $listeners = ['refreshComponent' => '$refresh'];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                    // BEGIN - Wizard - Proposta
                    Wizard::make([

                        // BEGIN - Wizard\Step - Proposta
                        Wizard\Step::make('Proposta')
                            ->icon('heroicon-o-clipboard-list')
                            ->schema([
                                
                                // BEGIN - Grid - Proposta
                                Grid::make([
                                    'default' => 1,
                                    'sm' => 1,
                                    'md' => 6,
                                    'lg' => 6,
                                    'xl' => 6,
                                    '2xl' => 8,
                                ])->schema([

                                    // BEGIN - Group - Dados Básicos e Detalhes
                                    Group::make()->schema([

                                        // BEGIN - Section - Dados Básicos
                                        Section::make('Dados Básicos')->schema([

                                            BelongsToSelect::make('customer_id')
                                                ->label('Cliente')
                                                ->required()
                                                ->searchable()
                                                ->relationship('customer', 'nome')
                                                ->preload(true)
                                                ->reactive()
                                                ->afterStateHydrated(fn ($state, callable $set) => $set('cliente.parceiro.nome', Customer::find($state)?->parceiro->nome ?? ''))
                                                ->afterStateUpdated(fn ($state, callable $set) => $set('cliente.parceiro.nome', Customer::find($state)?->parceiro->nome ?? ''))
                                                ->columnSpan([
                                                    'default' => 12,
                                                    'md' => 8,
                                                ])
                                                
                                            ,
                                            
                                            BelongsToSelect::make('proposal_status_id')
                                                ->label('Status')
                                                ->default(1)
                                                ->required()
                                                ->searchable()
                                                ->relationship('status', 'nome')
                                                ->preload(true)
                                                ->columnSpan([
                                                    'default' => 12,
                                                    'md' => 4,
                                                ])
                                                
                                            ,
                                           

                                            TextInput::make('validade')
                                                ->label('Validade (dias)')
                                                ->default('5')
                                                ->required()
                                                ->numeric()
                                                ->columnSpan([
                                                    'default' => 12,
                                                    'md' => 4,
                                                ])
                                            ,

                                            TextInput::make('prazo_entrega')
                                                ->label('Entrega (dias)')
                                                ->default(30)
                                                ->minValue(1)
                                                ->required()
                                                ->numeric()
                                                ->columnSpan([
                                                    'default' => 12,
                                                    'md' => 4,
                                                ])
                                            ,

                                            

                                            TextInput::make('desconto')
                                                ->mask(fn (Mask $mask) => $mask
                                                    ->patternBlocks([
                                                        'money' => fn (Mask $mask) => $mask
                                                            ->numeric()
                                                            ->decimalPlaces(2)
                                                            ->mapToDecimalSeparator([',', '.'])
                                                            ->thousandsSeparator('.')
                                                            ->decimalSeparator(',')
                                                            ->normalizeZeros(false)
                                                            ->padFractionalZeros(false)
                                                        ,
                                                    ])
                                                    ->pattern('R$ money')
                                                    ->lazyPlaceholder(false),
                                                )
                                                ->columnSpan([
                                                    'default' => 12,
                                                    'md' => 4,
                                                ])
                                            ,
    
    
                                        ])->columns(12)
                                        // END - Section - Dados Básicos

                                    ])->columnSpan([
                                        'md' => 6,
                                        
                                    ]), 
                                    // END - Group - Dados Básicos

                                    // BEGIN - Group - Detalhes
                                    Group::make()->schema([

                                        Section::make('Formas de Pagamento')->schema([ 
    
                                            TextInput::make('pgto_vista')
                                                ->label('Pagamento - Á Vista')
                                                ->maxLength(255)
                                                ->default('À Combinar')
                                                ->columnSpan([
                                                    'default' => 12,
                                                    'md' => 6,
                                                ])
                                            ,

                                            TextInput::make('pgto_boleto')
                                                ->label('Pagamento - Boleto')
                                                ->maxLength(255)
                                                ->default('À Combinar')
                                                ->columnSpan([
                                                    'default' => 12,
                                                    'md' => 6,
                                                ])
                                            ,

                                            TextInput::make('pgto_cartao')
                                                ->label('Pagamento - Cartão')
                                                ->maxLength(255)
                                                ->default('À Combinar')
                                                ->columnSpan([
                                                    'default' => 12,
                                                    'md' => 6,
                                                ])
                                            ,

                                            TextInput::make('pgto_outros')
                                                ->label('Pagamento - Outros')
                                                ->maxLength(255)
                                                ->default('À Combinar')
                                                ->columnSpan([
                                                    'default' => 12,
                                                    'md' => 6,
                                                ])
                                            ,
                                            
    
                                        ])->columns(12)
    
                                    ])->columnSpan([
                                        'md' => 6,
    
                                    ]), 
                                    // END - Group - Detalhes
                            

                                ])
                                // END - Grid - Proposta

                        ]),
                        // END - Wizard\Step - Proposta
                        
                        // BEGIN - Wizard\Step - Cabeceiras
                        Wizard\Step::make('Cabeceiras')
                            ->icon('heroicon-o-table')
                            ->schema([

                                // BEGIN - Grid - Cabeceiras
                                Grid::make([
                                    'default' => 1,
                                    'sm' => 1,
                                    'md' => 6,
                                    'lg' => 6,
                                    'xl' => 6,
                                    '2xl' => 8,
                                ])->schema([

                                    // BEGIN - Group - Configuração de Cabeceiras
                                    Group::make()->schema([

                                        // BEGIN - Section - Configuração de Cabeceiras
                                        // Section::make('Configuração de Cabeceiras')->schema([
                                
                                            // BEGIN - HasManyRepeater - Headboards
                                            HasManyRepeater::make('headboards')
                                                ->label('Cabeceiras')
                                                ->relationship('headboards')
                                                ->schema([

                                                    // BEGIN - WIZARD - Cabeceiras
                                                    Wizard::make([

                                                        // BEGIN - WIZARD\STEP - Dados da Cabeceira
                                                        Wizard\Step::make('Dados da Cabeceira')
                                                            ->icon('heroicon-o-table')
                                                            ->schema([
                                                                
                                                                // BEGIN - Grid - Dados da Cabeceira
                                                                Grid::make([
                                                                    'default' => 1,
                                                                    'sm' => 1,
                                                                    'md' => 6,
                                                                    'lg' => 6,
                                                                    'xl' => 6,
                                                                    '2xl' => 8,
                                                                ])->schema([

                                                                    // BEGN - Group - Dados Básico
                                                                    Group::make()->schema([

                                                                        Section::make('Dados Básicos')->schema([
                                    
                                                                            TextInput::make('largura')
                                                                                ->label('Largura (mm)')
                                                                                ->required()
                                                                                ->numeric()
                                                                                ->integer()
                                                                                ->columnSpan([
                                                                                    'default' => 12,
                                                                                    'md' => 6,
                                                                                ])
                                                                            ,
                                    
                                                                            TextInput::make('altura')
                                                                                ->label('Altura (mm)')
                                                                                ->required()
                                                                                ->numeric()
                                                                                ->integer()
                                                                                ->columnSpan([
                                                                                    'default' => 12,
                                                                                    'md' => 6,
                                                                                ])
                                                                            ,
                                    
                                                                            TextInput::make('valor_unitario')
                                                                                ->required()
                                                                                ->mask(fn (Mask $mask) => $mask
                                                                                    ->patternBlocks([
                                                                                        'money' => fn (Mask $mask) => $mask
                                                                                            ->numeric()
                                                                                            ->decimalPlaces(2)
                                                                                            ->mapToDecimalSeparator([',', '.'])
                                                                                            ->thousandsSeparator('.')
                                                                                            ->decimalSeparator(',')
                                                                                            ->normalizeZeros(false)
                                                                                            ->padFractionalZeros(false)
                                                                                            ->lazyPlaceholder()
                                                                                        ,
                                                                                    ])
                                                                                    ->pattern('R$ money'),
                                                                                )
                                                                                ->columnSpan([
                                                                                    'default' => 12,
                                                                                    'md' => 5,
                                                                                ])
                                                                            ,

                                                                            TextInput::make('qtd')
                                                                                ->label('Quantidade')
                                                                                ->lazy()
                                                                                ->reactive()
                                                                                ->afterStateUpdated(function (Closure $set, $state, $get) {
                                                                                    $set('valor_total', number_format($state * $get('valor_unitario'), 2, ',', '.') );
                                                                                })
                                                                                ->required()
                                                                                ->numeric()
                                                                                ->integer()
                                                                                ->columnSpan([
                                                                                    'default' => 12,
                                                                                    'md' => 2,
                                                                                ])
                                                                            ,

                                                                            TextInput::make('valor_total')
                                                                                ->disabled()
                                                                                ->prefix('R$')
                                                                                ->columnSpan([
                                                                                    'default' => 12,
                                                                                    'md' => 5,
                                                                                ])
                                                                            ,
                                    
                                                                            TextInput::make('obs_headboard')
                                                                                ->label('Observações da Cabeceira')
                                                                                ->maxLength(255)
                                                                                ->columnSpan([
                                                                                    'default' => 12,
                                                                                ])
                                                                            ,
                                    
                                    
                                                                        ])->columns(12)
                                    
                                                                    ])->columnSpan([
                                                                        'md' => 3,
                                                                        'lg' => 4,
                                                                        'xl' => 4,
                                                                    ]), 
                                                                    // END - Group - Dados Básico

                                                                    // BEGIN - Group - Detalhes
                                                                    Group::make()->schema([

                                                                        Section::make('Detalhes')->schema([ 
                                    
                                    
                                                                            TextInput::make('tecido')
                                                                                ->label('Tecido Escolhido')
                                                                                ->maxLength(50)
                                                                                ->required()
                                                                                ->columnSpan([
                                                                                    'default' => 12,
                                                                                ])
                                                                            ,
                                    
                                                                            Toggle::make('has_led')
                                                                                ->label('Fitas de Led')
                                                                                ->reactive()
                                                                                ->onIcon('heroicon-s-check')
                                                                                ->offIcon('heroicon-s-x')
                                                                                ->inline(false)
                                                                                ->columnSpan([
                                                                                    'default' => 12,
                                                                                ])
                                                                            ,
                                    
                                                                            TextInput::make('obs_led')
                                                                                ->label('Observações - Fita Led')
                                                                                ->maxLength(255)
                                                                                ->columnSpan([
                                                                                    'default' => 12,
                                                                                ])->visible(fn (Closure $get) => ($get('has_led') == true))
                                                                            ,
                                    
                                                                            Toggle::make('has_separador')
                                                                                ->label('Separadores em Metal')
                                                                                ->reactive()
                                                                                ->onIcon('heroicon-s-check')
                                                                                ->offIcon('heroicon-s-x')
                                                                                ->inline(false)
                                                                                ->columnSpan([
                                                                                    'default' => 12,
                                                                                ])
                                                                            ,
                                    
                                                                            TextInput::make('obs_separador')
                                                                                ->label('Observações - Separadores')
                                                                                ->maxLength(255)
                                                                                ->columnSpan([
                                                                                    'default' => 12,
                                                                                ])->visible(fn (Closure $get) => ($get('has_separador') == true))
                                                                            ,
                                    
                                                                            Toggle::make('has_tomada')
                                                                                ->label('Instalação de tomadas')
                                                                                ->onIcon('heroicon-s-check')
                                                                                ->offIcon('heroicon-s-x')
                                                                                ->inline(false)
                                                                                ->reactive()
                                                                                ->columnSpan([
                                                                                    'default' => 12,
                                                                                ])
                                                                            ,
                                    
                                                                            TextInput::make('qtd_tomada')
                                                                                ->numeric()
                                                                                ->integer()
                                                                                ->label('Quantidade de Tomadas')
                                                                                ->columnSpan([
                                                                                    'default' => 12,
                                                                                ])->visible(fn (Closure $get) => ($get('has_tomada') == true))
                                                                            ,
                                    
                                                                            TextInput::make('obs_tomada')
                                                                                ->label('Observações - Tomadas')
                                                                                ->maxLength(255)
                                                                                ->columnSpan([
                                                                                    'default' => 12,
                                                                                ])->visible(fn (Closure $get) => ($get('has_tomada') == true))
                                                                            ,
                                    
                                                                        ])->columns(12)
                                    
                                                                    ])->columnSpan([
                                                                        'md' => 3,
                                                                        'lg' => 2,
                                    
                                                                    ]), 
                                                                    // END - Group - Detalhes

                                                                ])
                                                                // END - Grid - Dados da Cabeceira
                                                        ]),
                                                        // END - WIZARD\STEP - Dados da Cabeceira

                                                        // BEGIN - WIZARD/STEP - Módulos
                                                        Wizard\Step::make('Módulos')
                                                            ->icon('heroicon-o-collection')
                                                            ->schema([
                                                                
                                                                // BEGIN - Grid - Módulos
                                                                Grid::make([
                                                                    'default' => 1,
                                                                    'sm' => 1,
                                                                    'md' => 6,
                                                                    'lg' => 6,
                                                                    'xl' => 6,
                                                                    '2xl' => 8,
                                                                ])->schema([

                                                                    // BEGIN - Módulos
                                                                    Group::make()->schema([

                                                                        // BEGIN - Section - Configuração de Módulos
                                                                        Section::make('Configuração de Módulos')->schema([
                                                                
                                                                            // BEGIN - HasManyRepeater - headboard_modules
                                                                            HasManyRepeater::make('headboard_modules')
                                                                                ->label('Módulos')
                                                                                ->relationship('modules')
                                                                                ->schema([
                                                                                    
                                                                                    TextInput::make('qtd')
                                                                                        ->label('Quantidade de Módulos')
                                                                                        ->minValue(1)
                                                                                        ->required()
                                                                                        ->numeric()
                                                                                        ->integer()
                                                                                        ->columnSpan([
                                                                                            'default' => 12,
                                                                                            'md' => 3,
                                                                                        ])
                                                                                    ,
                                    
                                                                                    TextInput::make('largura')
                                                                                        ->label('Largura (mm)')
                                                                                        ->required()
                                                                                        ->numeric()
                                                                                        ->integer()
                                                                                        ->columnSpan([
                                                                                            'default' => 12,
                                                                                            'md' => 3,
                                                                                        ])
                                                                                    ,
                                            
                                                                                    TextInput::make('altura')
                                                                                        ->label('Altura (mm)')
                                                                                        ->required()
                                                                                        ->numeric()
                                                                                        ->integer()
                                                                                        ->columnSpan([
                                                                                            'default' => 12,
                                                                                            'md' => 3,
                                                                                        ])
                                                                                    ,
                                    
                                                                                    TextInput::make('formato')
                                                                                        ->label('Formato do Módulo')
                                                                                        ->maxLength(50)
                                                                                        ->default('RETANGULAR')
                                                                                        ->columnSpan([
                                                                                            'default' => 12,
                                                                                            'md' => 3,
                                                                                        ])
                                                                                    ,
                                                                                    TextInput::make('obs_module')
                                                                                        ->label('Observações do Módulo')
                                                                                        ->maxLength(255)
                                                                                        ->columnSpan([
                                                                                            'default' => 12,
                                                                                        ])
                                                                                    ,
                                    
                                                                            ])->columns(12)
                                                                            // END - HasManyRepeater - headboard_modules
                                    
                                                                        ])
                                                                        // END - Section - Configuração de Módulos
                                    
                                                                    ])->columnSpan([
                                                                        'md' => 3,
                                                                        'lg' => 6,
                                                                    ]), 
                                                                    // END -Módulos

                                                                ])
                                                                // END - Grid - Módulos
                                                        ]),
                                                        // END - WIZARD/STEP - Módulos

                                                    ])
                                                    // END - WIZARD - Cabeceiras

                                            ])
                                            // END - HasManyRepeater - Headboards       
                                                    
    
                                        // ]),
                                        // END - Section - Configuração de Cabeceiras
    
                                    ])->columnSpan([
                                        'md' => 3,
                                        'lg' => 6,
                                    ]), 
                                    // END - Group - Configuração de Cabeceiras

                                ])
                                // END - Grid - Cabeceiras

                        ]),
                        // END - Wizard\Step - Cabeceiras

                        // BEGIN - Wizard\Step - Outros Items
                        Wizard\Step::make('Outros Items')
                            ->icon('heroicon-o-clipboard-copy')
                            ->schema([
                                
                                // BEGIN - Grid - Outros Items
                                Grid::make([
                                    'default' => 1,
                                    'sm' => 1,
                                    'md' => 6,
                                    'lg' => 6,
                                    'xl' => 6,
                                    '2xl' => 8,
                                ])->schema([

                                    // BEGIN - Group - Observações - Outros Items
                                    Group::make()->schema([

                                        // BEGIN - Section - Observações - Outros Items
                                        // Section::make('Outros Items')->schema([
                                
                                            // BEGIN - HasManyRepeater - proposal_items
                                            HasManyRepeater::make('proposal_items')
                                                ->label('Outros Items')
                                                ->relationship('proposalItems')
                                                ->schema([

                                                    TextInput::make('valor_unitario')
                                                        ->mask(fn (Mask $mask) => $mask
                                                            ->patternBlocks([
                                                                'money' => fn (Mask $mask) => $mask
                                                                    ->numeric()
                                                                    ->decimalPlaces(2)
                                                                    ->mapToDecimalSeparator([',', '.'])
                                                                    ->thousandsSeparator('.')
                                                                    ->decimalSeparator(',')
                                                                    ->normalizeZeros(false)
                                                                    ->padFractionalZeros(false)
                                                                    ->lazyPlaceholder()
                                                                ,
                                                            ])
                                                            ->pattern('R$ money'),
                                                        )
                                                        ->columnSpan([
                                                            'default' => 12,
                                                            'md' => 2,
                                                        ])
                                                    ,
                                                    
                                                    TextInput::make('qtd')
                                                        ->label('Quantidade')
                                                        ->numeric()
                                                        ->integer()
                                                        ->required()
                                                        ->reactive()
                                                        ->afterStateUpdated(function (Closure $set, $state, $get) {
                                                            $set('valor_total', number_format($state * $get('valor_unitario'), 2, ',', '.') );
                                                        })
                                                        ->lazy()
                                                        ->columnSpan([
                                                            'default' => 12,
                                                            'md' => 2,
                                                        ])
                                                    ,

                                                    TextInput::make('descricao')
                                                        ->label('Descrição')
                                                        ->required()
                                                        ->maxLength(255)
                                                        ->columnSpan([
                                                            'default' => 12,
                                                            'md' => 6,
                                                        ])
                                                    ,

                                                    TextInput::make('valor_total')
                                                        ->disabled()
                                                        ->prefix('R$')
                                                        ->columnSpan([
                                                            'default' => 12,
                                                            'md' => 2,
                                                        ])
                                                    ,

                                                    TextInput::make('obs_item')
                                                        ->label('Observações do Item')
                                                        ->maxLength(255)
                                                        ->columnSpan([
                                                            'default' => 12,
                                                        ])
                                                    ,

                                            ])->columns(12)
                                            // END - HasManyRepeater - proposal_items
                                                

                                        // ])
                                        // END - Section - Observações - Outros Items

                                    ])->columnSpan([
                                        'md' => 3,
                                        'lg' => 6,
                                    ]), 
                                    // END - Group - Observações - Outros Items

                                ])
                                // END - Grid - Outros Items

                        ]),
                        // END - Wizard\Step - Observações da Proposta

                        // BEGIN - Wizard\Step - Observações da Proposta
                        Wizard\Step::make('Observações da Proposta')
                            ->icon('heroicon-o-document-text')
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

                                        Section::make('Observações')->schema([
                                
                                            RichEditor::make('obs_proposal')
                                                

                                        ])

                                    ])->columnSpan([
                                        'md' => 3,
                                        'lg' => 6,
                                    ]), 

                                ])

                            ]),
                            // END - Wizard\Step - Observações da Proposta


                    ])->columnSpan(12)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('id')
                    ->label('#')
                    ->sortable()
                ,

                Tables\Columns\TextColumn::make('customer.nome')
                    ->label('Cliente')
                    ->sortable()
                ,

                Tables\Columns\TextColumn::make('customer.parceiro.nome')
                    ->label('Parceiro')
                    ->sortable()
                ,

                // BadgeColumn::make('status.nome')
                //     ->colors([
                //         'success',
                //         'primary' => 'Nova',
                //         'danger' => 'Reprovada',
                //         'warning' => 'Em Análise',
                        
                //     ]),

                ViewColumn::make('status')
                    ->view('filament.tables.columns.proposal-status')
                    ->url('#')
                ,

                ViewColumn::make('valor_total')->view('filament.tables.columns.proposal-valor-total'),
                
                // Tables\Columns\TextColumn::make('valor_total')
                //     ->label('Valor Total')
                //     ->sortable()
                //     ->money('brl'),

            ])->prependActions([
                Action::make('Imprimir')
                    ->url(fn (Proposal $record): string => route('proposal.pdf', $record))
                    ->openUrlInNewTab()
                    ->color('secondary')
                    ->icon('heroicon-o-printer')
            ])
            ->defaultSort('id', 'desc')
            ;
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


    public static function getGloballySearchableAttributes(): array
    {
        return ['id', 'customer.nome', 'customer.parceiro.nome'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        
        
        return [
            'Proposta' => 'PT-' . $record->id,
            'Cliente' => $record->customer->nome,
            'Valor Total' => $record->valor_total,
        ];
    }

}
