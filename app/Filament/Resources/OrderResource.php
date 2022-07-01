<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Helpers\Helpers;
use App\Models\PlanoConta;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Models\CategoriaConta;
use PhpParser\Node\Stmt\Label;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput\Mask;
use Filament\Forms\Components\BelongsToSelect;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\ContaCorrente;
use App\Models\FormaPagamento;
use App\Models\StatusConta;
use Carbon\Carbon;
use Filament\Forms\Components\Hidden;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-check';

    protected static ?string $navigationGroup = 'Operacional';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?string $navigationLabel = 'Pedidos';
    
    protected static ?string $slug = 'pedidos';

    protected static ?string $label = 'Pedido';

    protected static ?string $pluralLabel = 'Pedidos';

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
    
                    Section::make('Dados do Pedido')->schema([
                        
                        TextInput::make('id')
                            ->disabled()
                            ->label('Pedido Nº')
                            ->columnSpan([
                                'default' => 4,
                            ])
                        ,

                        TextInput::make('proposal_id')
                            ->disabled()
                            ->label('Proposta Nº')  
                            ->columnSpan([
                                'default' => 4,
                            ])
                        ,

                        DatePicker::make('created_at')
                            ->displayFormat('d/m/Y')
                            ->disabled()
                            ->label('Emitido em')  
                            ->columnSpan([
                                'default' => 4,
                            ])
                        ,

                        BelongsToSelect::make('customer')
                            ->relationship('customer', 'nome')
                            ->label('Cliente')
                            ->disabled()
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

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Pedido Nº')
                    ->formatStateUsing(fn (string $state): string => __(Helpers::setProposalNumber($state)))
                ,
                // TextColumn::make('proposal.id')
                //     ->label('Proposta Nº')
                //     ->formatStateUsing(fn (string $state): string => __(Helpers::setProposalNumber($state)))
                // ,
                TextColumn::make('customer.nome')
                    ->label('Cliente')
                ,
                TextColumn::make('customer.parceiro.nome')
                    ->label('Parceiro')
                ,
                ViewColumn::make('valor_total')->view('filament.tables.columns.order-total-value'),
                TextColumn::make('created_at')
                    ->label('Data do Pedido')
                    ->date('d/m/Y')
                ,
            ])
            ->actions([

                Action::make('edit')
                    ->tooltip('Adicionar Acompanhamento')
                    ->label('')
                    ->color('warning')
                    ->icon('heroicon-o-clipboard-check')
                    ->size('lg')
                    ->url(fn (Order $record): string => route('filament.resources.pedidos.edit', $record))
                ,

                Action::make('faturarPedido')
                    ->action('faturarPedido', fn (array $data): array => $data)
                    ->tooltip('Faturar Pedido')
                    ->label('')
                    ->color('success')
                    ->icon('heroicon-o-currency-dollar')
                    ->size('lg')
                    ->modalWidth('6xl')
                    ->modalButton('Faturar Pedido')
                    ->form([

                        /* BEGIN - Grid */
                        Grid::make([
                            'default' => 1,
                            'sm' => 2,
                            'md' => 3,
                            'lg' => 4,
                            'xl' => 6,
                            '2xl' => 8,
                        ])->schema([
            
                            /* BEGIN - Section - Dados do Faturamento */
                            Section::make('Faturar Pedido')->schema([
                                
                                TextInput::make('order_id')
                                    ->label('Pedido Nº')
                                    ->required()
                                    ->numeric()
                                    ->integer()
                                    ->default(fn (Order $record): string => $record->id)
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 2,
                                    ])
                                    ->disabled()
                                ,

                                TextInput::make('proposal_id')
                                    ->label('Proposta Nº')
                                    ->required()
                                    ->numeric()
                                    ->integer()
                                    ->default(fn (Order $record): string => $record->proposal->id)
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 2,
                                    ])
                                    ->disabled()
                                ,

                                Hidden::make('customer_id')
                                    ->label('Código do Cliente')
                                    ->required()
                                    ->default(fn (Order $record): string => $record->customer->id)
                                ,

                                TextInput::make('customer_nome')
                                    ->label('Nome do Cliente')
                                    ->required()
                                    ->default(fn (Order $record): string => $record->customer->nome)
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 8,
                                    ])
                                    ->disabled()
                                ,

                                Select::make('conta_corrente_id')
                                    ->label('Conta Corrente')
                                    ->required()
                                    ->options(ContaCorrente::all()->pluck('banco', 'id'))
                                    ->searchable() 
                                    ->preload(true)
                                    ->default(3)
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 4,
                                    ])
                                ,

                                Select::make('plano_conta_id')
                                    ->label('Plano de Contas')
                                    ->required()
                                    ->options(PlanoConta::Receitas()->pluck('nome', 'id'))
                                    ->reactive()
                                    ->afterStateUpdated(fn (callable $set) => $set('categoria_conta_id', null))
                                    ->searchable() 
                                    ->default(6)
                                    ->preload(true)
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 4,
                                    ])
                                ,

                                Select::make('categoria_conta_id')
                                    ->label('Categorias de Contas')
                                    ->required()
                                    ->options(function (callable $get) {
                                        $plano = PlanoConta::find($get('plano_conta_id'));

                                        if (! $plano) {
                                           return CategoriaConta::all()->pluck('nome', 'id');
                                        }

                                        return $plano->categoriasContas->pluck('nome', 'id');
                                    }) 
                                    ->default(15)
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 4,
                                    ])
                                ,

                                TextInput::make('valor_previsto')
                                    ->label('Valor Total do Pedido')
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
                                        ->pattern('R$ money')
                                    )
                                    ->default(fn (Order $record): float => ($record->proposal->headboards->sum('valor_total') + $record->proposal->proposalItems->sum('valor_total')))        
                                    ->disabled(true)
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 4,
                                    ])
                                ,

                                Select::make('forma_pagamento_id')
                                    ->label('Formas de Pagamento')
                                    ->required()
                                    ->options(FormaPagamento::all()->pluck('nome', 'id'))
                                    ->searchable() 
                                    ->preload(true)
                                    ->default(8)
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 4,
                                    ])
                                ,

                                Select::make('status_conta_id')
                                    ->label('Sitação Atual')
                                    ->required()
                                    ->options(StatusConta::all()->pluck('nome', 'id'))
                                    ->default(1)
                                    ->searchable() 
                                    ->preload(true)
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 4,
                                    ])
                                ,

                                TextInput::make('qtd_parcelas')
                                    ->label('Nº de Parcelas')
                                    ->required()
                                    ->numeric()
                                    ->integer()
                                    ->default(1)
                                    ->reactive()
                                    ->afterStateUpdated(fn (callable $set) => $set('valor_parcela', fn (callable $get): string => ($get('valor_previsto') / $get('qtd_parcelas'))))
                                    ->lazy()
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 2,
                                    ])
                                ,

                                TextInput::make('valor_parcela')
                                    ->label('Valor das Parcelas')
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
                                        ->pattern('R$ money')
                                    )
                                    ->default(fn (callable $get): float => ($get('valor_previsto') / $get('qtd_parcelas')))      
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 2,
                                    ])
                                ,

                                TextInput::make('valor_descontos')
                                    ->label('Descontos')
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
                                        ->pattern('R$ money')
                                    )
                                    ->default('0.00')      
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 2,
                                    ])
                                ,

                                TextInput::make('valor_acrescimos')
                                    ->label('Acréscimos')
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
                                        ->pattern('R$ money')
                                    )
                                    ->default('0.00')      
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 2,
                                    ])
                                ,

                                DatePicker::make('vencimento_em')
                                    ->label('Primeiro Vencimento')
                                    ->required()
                                    ->displayFormat('d/m/Y')
                                    ->default(Carbon::now())
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 4,
                                    ])
                                ,

                                TextInput::make('documento')
                                    ->label('Documento')
                                    ->default('PT-10 / PD-1')
                                    ->maxLength(250)
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 4,
                                    ])
                                ,

                                TextInput::make('observacoes')
                                    ->label('Observações')
                                    ->maxLength(250)
                                    ->default('PUBLICIDADE - REDES SOCIAIS')
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 8,
                                    ])
                                ,

            
                            ])->columnSpan([
                                    'md' => 6,
                            ])
                            ->columns(12),
                            /* END - Section - Dados do Faturamento */
            
                        ])
                        /* END - Grid */
                        
                    ])
                    /* END - Formulario */
                ,

            ])
            ;
    }
    
    public static function getRelations(): array
    {
        return [
            RelationManagers\StepsRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['id', 'customer.nome', 'customer.parceiro.nome', 'proposal_id'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        
        
        return [
            'Pedido' => 'PED-' . Helpers::setProposalNumber($record->id),
            'Cliente' => $record->customer->nome
        ];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return 'PED-' . Helpers::setProposalNumber($record->id);
    }

    

}
