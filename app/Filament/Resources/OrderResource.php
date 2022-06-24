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
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use Filament\Forms\Components\BelongsToSelect;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

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
                            ->format('d/m/Y')
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
                TextColumn::make('created_at')
                    ->label('Data do Pedido')
                    ->date('d/m/Y')
                ,
            ])
            ->filters([
                //
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
