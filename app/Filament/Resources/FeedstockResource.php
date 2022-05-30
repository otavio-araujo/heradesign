<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Feedstock;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\FeedstockResource\Pages;
use App\Filament\Resources\FeedstockResource\RelationManagers;

class FeedstockResource extends Resource
{
    protected static ?string $model = Feedstock::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Controle de Estoque';

    protected static ?int $navigationSort = 99;

    protected static ?string $recordTitleAttribute = 'nome';

    protected static ?string $navigationLabel = 'Matérias Primas';
    
    protected static ?string $slug = 'materias-primas';

    protected static ?string $label = 'Matéria Prima';

    protected static ?string $pluralLabel = 'Matérias Primas';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Produto')
                    ->schema([
                        Forms\Components\TextInput::make('nome')
                            ->required()
                            ->maxLength(150)
                            ->columnSpan([
                                'lg' => 6,
                            ]),

                        Forms\Components\TextInput::make('unidade_medida')
                            ->required()
                            ->maxLength(20)
                            ->columnSpan([
                                'lg' => 2,
                            ]),
                    ])
                    ->columns([
                        'md' => 8,
                    ])
                    ->columnSpan([
                        'md' => 9,
                     ]), 
                    Section::make('Alterações')
                        ->schema([
                            Forms\Components\Placeholder::make('created_at')
                                ->label('Data do cadastro')
                                ->content(fn (?Feedstock $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                            Forms\Components\Placeholder::make('updated_at')
                                ->label('Última atualização')
                                ->content(fn (?Feedstock $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                        ])
                    ->columnSpan(3),

            ])
            ->columns([
                'md' => 12,
                'lg' => null,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(static::getTableColumns())
            ->filters([
                //
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            RelationManagers\SuppliersRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFeedstocks::route('/'),
            'create' => Pages\CreateFeedstock::route('/create'),
            'edit' => Pages\EditFeedstock::route('/{record}/edit'),
        ];
    }

    public static function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('nome')
                ->label('Produto')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('unidade_medida')
                ->label('Unidade de Medida')
                ->searchable()
                ->sortable(),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['nome'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        
        
        return [
            'Nome' => $record->nome,
            'Un. Medida' => $record->unidade_medida,
        ];
    }
}
