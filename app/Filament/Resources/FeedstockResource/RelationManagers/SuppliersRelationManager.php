<?php

namespace App\Filament\Resources\FeedstockResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Helpers\Helpers;
use App\Models\Supplier;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
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
                    'md' => 3,
                    'lg' => 4,
                    'xl' => 6,
                    '2xl' => 8,
                ])->schema([

                Group::make()->schema([

                    Section::make('Dados Principais de Contato')->schema([

                        Forms\Components\TextInput::make('nome')
                            ->required()
                            ->maxLength(150)
                            ->columnSpan([
                                'default' => 12,
                                'md' => 12, 
                                'lg' => 7  
                            ])
                        ,
                        
                        Forms\Components\TextInput::make('cnpj')
                            ->unique(Fornecedor::class, 'cnpj', fn ($record) => $record)
                            ->mask(fn (TextInput\Mask $mask) => $mask->pattern('00.000.000/0000-00'))
                            ->columnSpan([
                                'default' => 12,
                                'md' => 7,
                                'lg' => 5
                            ])
                        ,

                        Forms\Components\TextInput::make('contato')
                            ->label('Contato')
                            ->maxLength(15)
                            ->columnSpan([
                                'default' => 12,
                                'md' => 5,
                                'lg' => 3
                            ])
                        ,

                        Forms\Components\TextInput::make('whatsapp')
                            ->maxLength(15)
                            ->mask(fn (TextInput\Mask $mask) => $mask->pattern('(00) 00000-0000'))
                            ->columnSpan([
                                'default' => 12,
                                'md' => 4,
                                'lg' => 3
                            ])
                        ,

                        Forms\Components\TextInput::make('telefone')
                            ->maxLength(15)
                            ->mask(fn (TextInput\Mask $mask) => $mask->pattern('(00) 0000-0000'))
                            ->columnSpan([
                                'default' => 12,
                                'md' => 4,
                                'lg' => 3
                            ])
                        ,

                        Forms\Components\TextInput::make('celular')
                            ->maxLength(15)
                            ->mask(fn (TextInput\Mask $mask) => $mask->pattern('(00) 00000-0000'))
                            ->columnSpan([
                                'default' => 12,
                                'md' => 4,
                                'lg' => 3
                            ])
                        ,

                        /* Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255)
                            ->columnSpan(12)
                        , */

                    ])->columns([
                            'md' => 12
                        ]),
    
                    /* Section::make('Endereço')->schema([

                        Forms\Components\TextInput::make('cep')
                            ->maxLength(9)
                            ->mask(fn (TextInput\Mask $mask) => $mask->pattern('00000-000'))
                            ->columnSpan([
                                'default' => 12,
                                'md' => 3,
                            ])
                        ,

                        Forms\Components\TextInput::make('endereco')
                            ->maxLength(255)
                            ->columnSpan([
                                'default' => 12,
                                'md' => 9,
                            ])
                        ,

                        Forms\Components\TextInput::make('bairro')
                            ->maxLength(150)
                            ->columnSpan([
                                'default' => 12,
                                'md' => 5,
                            ])
                        ,

                        Forms\Components\TextInput::make('cidade')
                            ->maxLength(150)
                            ->columnSpan([
                                'default' => 12,
                                'md' => 5,
                            ])
                        ,

                        Forms\Components\TextInput::make('uf')
                            ->maxLength(2)
                            ->columnSpan([
                                'default' => 12,
                                'md' => 2,
                            ])
                        ,                 
                    
                        Forms\Components\TextInput::make('numero')
                            ->maxLength(10)
                            ->mask(fn (TextInput\Mask $mask) => $mask->pattern('0000000000'))
                            ->columnSpan([
                                'default' => 12,
                                'md' => 5,
                            ])
                        ,

                        Forms\Components\TextInput::make('complemento')
                            ->maxLength(100)
                            ->columnSpan([
                                'default' => 12,
                                'md' => 7,
                            ])
                        ,

                    ])->columns([
                            'md' => 12
                        ]), */

                ])->columnSpan([
                        'default' => 1,
                        'sm' => 1,
                        'md' => 3,
                        'lg' => 4,
                        'xl' => 6,
                        '2xl' => 8,
                     ]),
                    
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

                Forms\Components\TextInput::make('preco')
                    ->label('Preço')
                    ->numeric()
                    ->rules(['regex:/^(\d+(\.\d{0,2})?|\.?\d{1,2})$/'])
                    ->required()
                    ->prefix('R$ '),
            ]);
    }

}
