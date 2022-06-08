<?php

namespace App\Filament\Resources\FeedstockResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Cidade;
use App\Helpers\Helpers;
use App\Models\Supplier;
use App\Models\PersonType;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextInput\Mask;
use Filament\Resources\RelationManagers\BelongsToManyRelationManager;

class SuppliersRelationManager extends BelongsToManyRelationManager
{
    protected static string $relationship = 'suppliers';

    protected static ?string $recordTitleAttribute = 'nome';

    protected static ?string $label = 'Fornecedor';

    protected static ?string $pluralLabel = 'Fornecedores';

    public static function form(Form $form): Form
    {
        
        return $form->schema([

            Grid::make([
                    'default' => 1,
                    'sm' => 1,
                    'md' => 6,
                    '2xl' => 8,
                ])->schema([


                Section::make('Dados do Fornecedor')->schema([
                    
                    Select::make('person_type_id')
                        ->label('Tipo de Pessoa')
                        ->required()
                        ->options(PersonType::all()->pluck('nome', 'id'))
                        ->searchable()
                        ->reactive()
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
                            ->label('UF')
                            ->disabled()
                            ->maxLength(2)
                            ->columnSpan([
                                'default' => 12,
                                'md' => 2,
                            ])
                    , 

                    Forms\Components\TextInput::make('nome')
                        ->required()
                        ->maxLength(150)
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,  
                        ])
                    ,

                    Forms\Components\TextInput::make('contato')
                        ->label('Contato')
                        ->maxLength(15)
                        ->columnSpan([
                            'default' => 12,
                            'md' => 5,
                            'lg' => 6
                        ])
                    ,

                    Forms\Components\TextInput::make('whatsapp')
                        ->maxLength(15)
                        ->mask(fn (TextInput\Mask $mask) => $mask->pattern('(00) 00000-0000'))
                        ->columnSpan([
                            'default' => 12,
                            'md' => 4,
                            'lg' => 6
                        ])
                    ,

                ])
                    ->columns([
                        'md' => 12
                    ])

                    ->columnSpan([
                        'md' => 4
                    ])
                ,

                Section::make('Preço da Matéria Prima')->schema([

                    TextInput::make('preco')
                        ->label('Preço da Matéria Prima')
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
                            ->pattern('R$ money'),
                        )
                    ,

                ])
                    ->columns([
                        'md' => 1
                    ])
                    
                    ->columnSpan([
                        'md' => 2
                    ])
                ,
                    
            ])

        ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->label('Nome')
                    ->sortable(),

                Tables\Columns\TextColumn::make('contato'),

                Tables\Columns\TextColumn::make('whatsapp'),

                Tables\Columns\TextColumn::make('preco')
                    ->label('Preço')
                    ->sortable()
                    ->money('brl'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Última Cotação')
                    ->date('d/m/Y'),
            ])
            ->filters([
                //
            ]);
    }


    public static function attachForm(Form $form): Form
    {
        return $form
            ->schema([
                static::getAttachFormRecordSelect()
                    ->required()
                    ->label('Fornecedor'),

                TextInput::make('preco')
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
                        ->pattern('R$ money'),
                    )
                ,
            ]);
    }

}
