<?php

namespace App\Filament\Resources\SupplierResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Resources\RelationManagers\BelongsToManyRelationManager;

class FeedstocksRelationManager extends BelongsToManyRelationManager
{
    protected static string $relationship = 'feedstocks';

    protected static ?string $recordTitleAttribute = 'nome';

    protected static ?string $label = 'Matéria Prima';

    protected static ?string $pluralLabel = 'Matérias Primas';

    protected function mutateFormDataBeforeFill(array $data): array
    {
        
        $data['preco'] = $data['preco'] / 100;
    
        return $data;
    }

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

                    Forms\Components\TextInput::make('preco')
                        ->label('Preço')
                        ->numeric()
                        ->rules(['regex:/^(\d+(\.\d{0,2})?|\.?\d{1,2})$/'])
                        ->required()
                        ->prefix('R$ ')
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

                Forms\Components\TextInput::make('preco')
                    ->label('Preço')
                    ->numeric()
                    ->rules(['regex:/^(\d+(\.\d{0,2})?|\.?\d{1,2})$/'])
                    ->required()
                    ->prefix('R$ '),
            ]);
    }

}