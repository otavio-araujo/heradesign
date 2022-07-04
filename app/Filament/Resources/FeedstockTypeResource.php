<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use App\Models\FeedstockType;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\FeedstockTypeResource\Pages;
use App\Filament\Resources\FeedstockTypeResource\RelationManagers;
use App\Filament\Resources\FeedstockTypeResource\Pages\EditFeedstockType;
use App\Filament\Resources\FeedstockTypeResource\Pages\ListFeedstockTypes;
use App\Filament\Resources\FeedstockTypeResource\Pages\CreateFeedstockType;

class FeedstockTypeResource extends Resource
{
    protected static ?string $model = FeedstockType::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Cadastros Auxiliares';

    protected static ?int $navigationSort = 104;

    protected static ?string $recordTitleAttribute = 'nome';

    protected static ?string $navigationLabel = 'Tipo de Matérias Primas';
    
    protected static ?string $slug = 'tipos-de-materias-primas';

    protected static ?string $label = 'Tipo de Matéria Prima';

    protected static ?string $pluralLabel = 'Tipos de Matérias Primas';

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
    
                    Section::make('Novo Tipo de Matéria Prima')->schema([
                        
                        TextInput::make('nome')
                            ->autofocus()
                            ->label('Nome')
                            ->required()
                            ->unique(FeedstockType::class, 'nome', fn ($record) => $record)
                            ->maxLength(100)
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
                
                TextColumn::make('nome')
                    ->label('Produto')
                    ->searchable()
                    ->sortable(),

                ])
                ->defaultSort('nome')
                ->actions([
                    Tables\Actions\EditAction::make()
                    ->tooltip('Editar Tipo de Matéria Prima')
                    ->label('')
                    ->icon('heroicon-o-pencil')
                    ->size('lg'),
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
            'index' => Pages\ListFeedstockTypes::route('/'),
            'create' => Pages\CreateFeedstockType::route('/create'),
            'edit' => Pages\EditFeedstockType::route('/{record}/edit'),
        ];
    }
}
