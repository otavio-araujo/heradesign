<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Cidade;
use App\Models\ContaPagar;
use App\Models\PersonType;
use App\Models\PlanoConta;
use App\Models\StatusConta;
use Filament\Resources\Form;
use App\Models\ContaCorrente;
use Filament\Resources\Table;
use App\Models\CategoriaConta;
use App\Models\FormaPagamento;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\TextInput\Mask;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ContaPagarResource\Pages;
use App\Filament\Resources\ContaPagarResource\RelationManagers;

class ContaPagarResource extends Resource
{
    protected static ?string $model = ContaPagar::class;

    protected static ?string $navigationIcon = 'heroicon-o-thumb-down';

    protected static ?string $navigationGroup = 'Financeiro';

    protected static ?int $navigationSort = 3;

    // protected static ?string $recordTitleAttribute = '';

    protected static ?string $navigationLabel = 'Contas a Pagar';
    
    protected static ?string $slug = 'contas-a-pagar';

    protected static ?string $label = 'Conta a Pagar';

    protected static ?string $pluralLabel = 'Contas a Pagar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
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
                    Section::make('Nova Conta a Pagar')->schema([


                        Select::make('supplier_id')
                            ->label('Fornecedor')
                            ->required()
                            ->relationship('supplier', 'nome')
                            ->searchable() 
                            ->preload(true)
                            ->columnSpan([
                                'default' => 'full',
                                'md' => 4,
                            ])
                            ->createOptionForm([

                                Section::make('Novo Fornecedor')->schema([

                                    TextInput::make('nome')
                                        ->required()
                                        ->unique()
                                        ->columnSpan([
                                            'default' => 12,
                                            'md' => 12,
                                        ])
                                    ,

                                    Select::make('person_type_id')
                                        ->label('Tipo de Pessoa')
                                        ->required()
                                        ->options(PersonType::all()->pluck('nome', 'id'))
                                        ->searchable()
                                        ->preload(true)
                                        ->columnSpan([
                                            'default' => 12,
                                            'md' => 4,
                                        ])
                                    ,

                                    Select::make('cidade_id')
                                        ->label('Cidade')
                                        ->required()
                                        ->searchable()
                                        ->options(Cidade::all()->pluck('nome', 'id'))
                                        ->reactive()
                                        ->afterStateHydrated(fn ($state, callable $set) => $set('uf', Cidade::find($state)?->estado->uf ?? ''))
                                        ->afterStateUpdated(fn ($state, callable $set) => $set('uf', Cidade::find($state)?->estado->uf ?? ''))
                                        ->columnSpan([
                                            'default' => 12,
                                            'md' => 6,
                                        ])
                                    ,

                                    Forms\Components\TextInput::make('uf')
                                        ->label('UF')
                                        ->disabled()
                                        ->maxLength(2)
                                        ->columnSpan([
                                            'default' => 12,
                                            'md' => 2,
                                        ])
                                    ,

                                ])->columns(12),
                                
                            ])
                            ->createOptionAction(fn ($action) => $action->modalHeading('Cadastrar Fornecedor'))
                        ,

                        Select::make('conta_corrente_id')
                            ->label('Conta Corrente')
                            ->required()
                            ->relationship('contaCorrente', 'banco')
                            ->searchable() 
                            ->preload(true)
                            ->default(2)
                            ->columnSpan([
                                'default' => 'full',
                                'md' => 4,
                            ])
                        ,

                        Select::make('status_conta_id')
                            ->label('Sitação Atual')
                            ->required()
                            ->relationship('statusConta', 'nome')
                            ->default(1)
                            ->searchable() 
                            ->preload(true)
                            ->columnSpan([
                                'default' => 'full',
                                'md' => 4,
                            ])
                        ,

                        Select::make('plano_conta_id')
                            ->label('Plano de Contas')
                            ->required()
                            ->options(PlanoConta::Despesas()->pluck('nome', 'id'))
                            ->reactive()
                            ->afterStateUpdated(fn (callable $set) => $set('categoria_conta_id', null))
                            ->searchable()
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
                            ->columnSpan([
                                'default' => 'full',
                                'md' => 4,
                            ])
                        ,

                        Select::make('forma_pagamento_id')
                            ->label('Formas de Pagamento')
                            ->required()
                            ->relationship('formaPagamento', 'nome')
                            ->default(7)
                            ->searchable() 
                            ->preload(true)
                            ->columnSpan([
                                'default' => 'full',
                                'md' => 4,
                            ])
                        ,

                        

                        TextInput::make('valor_previsto')
                            ->label('Total a Pagar')
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
                            ->default('0.00') 
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
                            ->columnSpan([
                                'default' => 'full',
                                'md' => 2,
                            ])
                        ,

                        DatePicker::make('vencimento_em')
                            ->label('1º Vencimento')
                            ->required()
                            ->displayFormat('d/m/Y')
                            ->default(Carbon::now())
                            ->columnSpan([
                                'default' => 'full',
                                'md' => 2,
                            ])
                        ,

                        TextInput::make('documento')
                            ->label('Documento')
                            ->maxLength(250)
                            ->columnSpan([
                                'default' => 'full',
                                'md' => 4,
                            ])
                        ,

                        TextInput::make('observacoes')
                            ->label('Observações')
                            ->maxLength(250)
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
                

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('contaCorrente.banco')
                    ->label('Conta Corrente')
                    ->sortable()
                ,
                
                TextColumn::make('vencimento_em')
                    ->label('Vencimento')
                    ->date('d/m/Y')
                    ->sortable()
                ,

                TextColumn::make('descricao')
                    ->label('Descrição')
                    ->searchable()
                    ->wrap()
                    ->extraAttributes(['class' => 'text-xs'])
                ,

                TextColumn::make('valor_parcela')
                    ->label('Valor da Parcela')
                    ->money('BRL')
                ,

                TextColumn::make('valor_pago')
                    ->label('Total Pago')
                    ->money('BRL')
                ,

                ViewColumn::make('statusConta.nome')
                    ->label('Situação')
                    ->view('filament.tables.columns.status-conta')
                    ->sortable()
                ,
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->tooltip('Editar Conta a Receber')
                    ->label('')
                    ->icon('heroicon-o-pencil')
                    ->size('lg')
                ,

                Tables\Actions\Action::make('baixarConta')
                    ->action('baixarConta', fn (array $data): array => $data)
                    ->tooltip('Baixar Conta a Pagar')
                    ->label('')
                    ->color('success')
                    ->icon('heroicon-o-thumb-up')
                    ->size('lg')
                    ->modalWidth('5xl')
                    ->modalButton('Baixar Conta')
                    ->visible(fn (ContaPagar $record): bool => $record->pago_em == null)
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
                            Section::make(fn (ContaPagar $record): string => $record->supplier->nome)->schema([

                                Hidden::make('id')
                                    ->default(fn (ContaPagar $record): string => $record->id)
                                ,
                                
                                TextInput::make('conta_corrente_nome')
                                    ->label('Conta Corrente')
                                    ->default(fn (ContaPagar $record): string => $record->contaCorrente->banco . ' | AG: ' . $record->contaCorrente->agencia . '/ CC: ' . $record->contaCorrente->agencia)
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 4,
                                    ])
                                    ->disabled()
                                ,

                                TextInput::make('plano_conta_nome')
                                    ->label('Plano de Conta')
                                    ->default(fn (ContaPagar $record): string => $record->planoConta->nome)
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 4,
                                    ])
                                    ->disabled()
                                ,

                                TextInput::make('categoria_conta_nome')
                                    ->label('Categoria da Conta')
                                    ->default(fn (ContaPagar $record): string => $record->categoriaConta->nome)
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 4,
                                    ])
                                    ->disabled()
                                ,

                                TextInput::make('valor_previsto')
                                    ->label('Valor do Pedido')
                                    ->default(fn (ContaPagar $record): string => 'R$' . number_format($record->valor_previsto, 2, ',', '.'))
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 2,
                                    ])
                                    ->disabled()
                                ,

                                TextInput::make('valor_parcela')
                                    ->label('Valor da Parcela')
                                    ->default(fn (ContaPagar $record): string => 'R$' . number_format($record->valor_parcela, 2, ',', '.'))
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 2,
                                    ])
                                    ->disabled()
                                ,

                                TextInput::make('parcela_atual')
                                    ->label('Parcela')
                                    ->default(fn (ContaPagar $record): string => $record->parcela_atual . ' DE ' . $record->qtd_parcelas)
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 2,
                                    ])
                                    ->disabled()
                                ,

                                DatePicker::make('vencimento_em')
                                    ->label('Vencimento em')
                                    ->displayFormat('d/m/Y')
                                    ->default(fn (ContaPagar $record): string => Carbon::make($record->vencimento_em)->format('Y-m-d'))
                                    ->disabled()
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 2,
                                    ])
                                ,

                                TextInput::make('documento')
                                    ->label('Documento')
                                    ->default(fn (ContaPagar $record): string => $record->documento)
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 4,
                                    ])
                                    ->disabled()
                                ,

                                
                                DatePicker::make('pago_em')
                                    ->label('Pago em')
                                    ->required()
                                    ->format('Y-m-d')
                                    ->displayFormat('d/m/Y')
                                    ->default(fn (ContaPagar $record): string => Carbon::make($record->vencimento_em)->format('Y-m-d'))
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 3,
                                    ])
                                ,

                                DatePicker::make('liquidado_em')
                                    ->label('Liquidado em')
                                    ->required()
                                    ->format('Y-m-d')
                                    ->displayFormat('d/m/Y')
                                    ->default(fn (ContaPagar $record): string => Carbon::make($record->vencimento_em)->format('Y-m-d'))
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 3,
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
                                    ->default(fn (ContaPagar $record): string => $record->valor_descontos)     
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
                                    ->default(fn (ContaPagar $record): string => $record->valor_acrescimos)      
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 2,
                                    ])
                                ,

                                TextInput::make('valor_pago')
                                    ->label('Valor Pago')
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
                                    ->default(fn (ContaPagar $record): string => $record->valor_parcela)      
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 2,
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
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListContaPagars::route('/'),
            'create' => Pages\CreateContaPagar::route('/create'),
            'edit' => Pages\EditContaPagar::route('/{record}/edit'),
        ];
    } 
    
}
