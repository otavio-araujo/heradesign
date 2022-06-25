<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Helpers\Helpers;
use Filament\Resources\Form;
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
                TextColumn::make('proposal.id')
                    ->label('Proposta Nº')
                    ->formatStateUsing(fn (string $state): string => __(Helpers::setProposalNumber($state)))
                ,
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
