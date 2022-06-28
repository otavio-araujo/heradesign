<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Helpers\Helpers;
use App\Models\BillingType;
use Filament\Resources\Form;
use App\Models\BillingStatus;
use Filament\Resources\Table;
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
                    ->modalHeading('Faturar Pedido')
                    ->modalButton('Faturar Pedido')
                    ->form([
                        TextInput::make('order_id')
                            ->label('Pedido Nº')
                            ->numeric()
                            ->integer()
                            ->default(fn (Order $record): string => $record->id)
                            ->disabled()
                        ,

                        TextInput::make('proposal_id')
                            ->label('Proposta Nº')
                            ->numeric()
                            ->integer()
                            ->default(fn (Order $record): string => $record->proposal->id)
                            ->disabled()
                        ,

                        TextInput::make('customer_id')
                            ->label('Código do Cliente')
                            ->default(fn (Order $record): string => $record->customer->id)
                            ->disabled()
                        ,

                        TextInput::make('customer_nome')
                            ->label('Nome do Cliente')
                            ->default(fn (Order $record): string => $record->customer->nome)
                            ->disabled()
                        ,

                        Select::make('billing_status_id')
                            ->label('Situação')
                            ->options(BillingStatus::all()->pluck('nome', 'id'))
                            ->searchable() 
                            ->required()
                        ,

                        Select::make('billing_type_id')
                            ->label('Tipo de Pagamento')
                            ->searchable()
                            ->options(BillingType::all()->pluck('nome', 'id'))
                            ->required()
                        ,

                        TextInput::make('valor_total')
                            ->label('Valor Total do Pedido')
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
                        ,

                        TextInput::make('qtd_parcelas')
                            ->label('Quantidade de Parcelas')
                            ->numeric()
                            ->integer()
                            ->default(1)
                            ->required()
                        ,

                        DatePicker::make('data_vencimento')
                            ->label('Primeiro Vencimento')
                            ->displayFormat('d/m/Y')
                            ->required()
                        ,

                        TextInput::make('documento')
                            ->label('Documento')
                            ->maxLength(250)
                        ,

                        TextInput::make('observacoes')
                            ->label('Observações')
                            ->maxLength(250)
                        ,

                        
                    ])
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
