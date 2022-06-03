<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Customer;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Select;
use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Partner;
use App\Models\PersonType;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Operacional';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'nome';

    protected static ?string $navigationLabel = 'Clientes';
    
    protected static ?string $slug = 'clientes';

    protected static ?string $label = 'Cliente';

    protected static ?string $pluralLabel = 'Clientes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Grid::make(8)->schema([

                    Tabs::make('Heading')
                        ->tabs([

                            Tabs\Tab::make('Dados Cadastrais')
                                ->schema([

                                    Select::make('person_type_id')
                                        ->label('Tipo de Pessoa')
                                        ->required()
                                        ->options(PersonType::all()->pluck('nome', 'id'))
                                        ->searchable()
                                        ->columnSpan([
                                            'default' => 12,
                                            'md' => 6,
                                        ])
                                    ,

                                    Select::make('partner_id')
                                        ->label('Parceiro Responsável')
                                        ->required()
                                        ->searchable()
                                        ->getSearchResultsUsing(fn (string $searchQuery) => Partner::where('nome', 'like', "%{$searchQuery}%")->limit(50)->pluck('nome', 'id'))
                                        ->getOptionLabelUsing(fn ($value): ?string => Partner::find($value)?->nome)
                                        ->reactive()
                                        ->afterStateHydrated(fn ($state, callable $set) => $set('uf', Partner::find($state)?->estado->uf ?? ''))
                                        ->afterStateUpdated(fn ($state, callable $set) => $set('uf', Partner::find($state)?->estado->uf ?? ''))
                                        ->columnSpan([
                                            'default' => 12,
                                            'md' => 6,
                                        ])
                                    ,
                                    
                                    Forms\Components\TextInput::make('nome')
                                        ->required()
                                        ->maxLength(150)
                                        ->columnSpan([
                                            'default' => 12,
                                            'md' => 6, 
                                        ])
                                    ,

                                    Forms\Components\TextInput::make('nome_fantasia')
                                        ->required()
                                        ->maxLength(150)
                                        ->columnSpan([
                                            'default' => 12,
                                            'md' => 6, 
                                        ])
                                    ,

                                    

                                ]),

                            Tabs\Tab::make('Contatos')
                                ->schema([
                                    // ...
                                ]),

                            Tabs\Tab::make('Correspondência')
                                ->schema([
                                    // ...
                                ]),

                    ])->columnSpan(8)->columns([
                                            'default' => 1,
                                            'md' => 12,
                                        ])

                ]),

                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
