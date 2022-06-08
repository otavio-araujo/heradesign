<?php

namespace App\Filament\Resources\SupplierResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextInput\Mask;
use Filament\Resources\RelationManagers\BelongsToManyRelationManager;

class FeedstocksRelationManager extends BelongsToManyRelationManager
{
    protected static string $relationship = 'feedstocks';

    protected static ?string $recordTitleAttribute = 'nome';

    protected static ?string $label = 'Matéria Prima';

    protected static ?string $pluralLabel = 'Matérias Primas';

    public static function form(Form $form): Form
    {
        return $form->schema([

            Grid::make([
                'default' => 1,
                'sm' => 2,
                'md' => 3,
                'lg' => 4,
                'xl' => 6,
                '2xl' => 8,
            ])->schema([

                Section::make('Dados da Matéria Prima')->schema([
                    
                    Forms\Components\TextInput::make('nome')
                        ->required()
                        ->maxLength(150)
                        ->columnSpan([
                            'md' => 6
                        ])
                    ,

                    Forms\Components\TextInput::make('unidade_medida')
                        ->label('Unidade de Medida')
                        ->required()
                        ->maxLength(20)
                        ->columnSpan([
                            'md' => 3
                        ])
                    ,

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
                        ->columnSpan([
                            'md' => 3
                        ])
                    ,

                ])->columns([
                        'md' => 12
                    ]),

            ])

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->label('Produto')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('unidade_medida')
                    ->label('Unidade de Medida'),

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
                    ->label('Matéria Prima'),

                TextInput::make('preco')->mask(fn (Mask $mask) => $mask
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
                ),

            ]);
    }

}