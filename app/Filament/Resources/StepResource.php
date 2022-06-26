<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Step;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\StepResource\Pages;
use App\Filament\Resources\StepResource\RelationManagers;

class StepResource extends Resource
{
    protected static ?string $model = Step::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Cadastros Auxiliares';

    protected static ?int $navigationSort = 30;

    protected static ?string $recordTitleAttribute = 'nome';

    protected static ?string $navigationLabel = 'Acompanhamentos de Pedidos';
    
    protected static ?string $slug = 'acompanhamento-de-pedidos';

    protected static ?string $label = 'Acompanhamento de Pedidos';

    protected static ?string $pluralLabel = 'Acompanhamentos de Pedidos';

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
    
                    Section::make('Acompanhamento de Ordens')->schema([
                        
                        TextInput::make('nome')
                            ->autofocus()
                            ->label('Nome')
                            ->required()
                            ->unique(Step::class, 'nome', fn ($record) => $record)
                            ->maxLength(50)
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
                // TextColumn::make('nome')
                //     ->searchable()    
                // ,
                ViewColumn::make('nome')
                    ->label('Nome')
                    ->view('filament.tables.columns.steps-badge')
                ,
                TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->date('d/m/Y')
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
            'index' => Pages\ListSteps::route('/'),
            'create' => Pages\CreateStep::route('/create'),
            'edit' => Pages\EditStep::route('/{record}/edit'),
        ];
    }
}
