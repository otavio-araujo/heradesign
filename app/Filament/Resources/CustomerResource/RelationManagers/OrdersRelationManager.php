<?php

namespace App\Filament\Resources\CustomerResource\RelationManagers;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Helpers\Helpers;
use App\Models\PlanoConta;
use App\Models\StatusConta;
use App\Models\ContaReceber;
use Filament\Resources\Form;
use App\Models\ContaCorrente;
use Filament\Resources\Table;
use App\Models\CategoriaConta;
use App\Models\FormaPagamento;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\TextInput\Mask;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->required()
                    ->maxLength(255),
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
                    ->visible(fn (Order $record): bool => $record->faturado == 0) 
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
                                    ->default(2)
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
                        
                    ])
                    /* END - Formulario */
                ,

            ])
            ;
    }  

    public function faturarPedido(Array $data)
    {
        
        $parcela_atual = 1;

        while ($parcela_atual <= $data['qtd_parcelas']) {

            $data['parcela_atual'] = $parcela_atual;

            if ($parcela_atual > 1) {
                $data['vencimento_em'] = Carbon::make($data['vencimento_em'])->addMonth(1)->format('Y-m-d');
            }

            if ($parcela_atual == $data['qtd_parcelas']) {

                $total_parcelas = bcmul($data['qtd_parcelas'], $data['valor_parcela'], 2);
                $diferenca = bcsub($data['valor_previsto'], $total_parcelas, 2);
                
                $data['valor_parcela'] = bcadd($data['valor_parcela'], $diferenca, 2);
            }

            $data['descricao'] = Helpers::getDescricaoReceber($data, $data['parcela_atual']);

            ContaReceber::create($data);          
            
            $parcela_atual++;

        }

        $order = Order::find($data['order_id']);
        $order->faturado = 1;
        $order->save();

        $this->notify('success', 'Pedido Faturado com Sucesso!');
    }
}
