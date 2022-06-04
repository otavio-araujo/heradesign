<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Feedstock;
use Filament\Resources\Form;
use App\Models\UnidadeMedida;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\FeedstockResource\Pages;
use App\Filament\Resources\FeedstockResource\RelationManagers;

class FeedstockResource extends Resource
{
    protected static ?string $model = Feedstock::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Fornecedores e Materiais';

    protected static ?int $navigationSort = 99;

    protected static ?string $recordTitleAttribute = 'nome';

    protected static ?string $navigationLabel = 'Matérias Primas';
    
    protected static ?string $slug = 'materias-primas';

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

                Section::make('Produto')->schema([
                    
                    Forms\Components\TextInput::make('nome')
                        ->autofocus()
                        ->required()
                        ->unique(Feedstock::class, 'nome', fn($record) => $record)
                        ->maxLength(150)
                    ,

                    Select::make('unidade_medida_id')
                        ->label('Unidade de Medida')
                        ->required()
                        ->options(UnidadeMedida::all()->pluck('nome', 'id'))
                        ->searchable()
                    ,

                ])->columnSpan([
                    'md' => 2,
                    'lg' => 3,
                    'xl' => 4,
                ]),

                Section::make('Alterações')->schema([

                    Forms\Components\Placeholder::make('created_at')
                        ->label('Data do cadastro')
                        ->content(fn (?Feedstock $record): string => $record ? $record->created_at->diffForHumans() : '-'),

                    Forms\Components\Placeholder::make('updated_at')
                        ->label('Última atualização')
                        ->content(fn (?Feedstock $record): string => $record ? $record->updated_at->diffForHumans() : '-'),

                ])->columnSpan([
                    'md' => 1,
                    'xl' => 2,
                ]),

            ])

        ]);
            
    }


    public static function table(Table $table): Table
    {
        
        return $table
            ->columns(static::getTableColumns())
            ->filters([
                
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

            Tables\Columns\TextColumn::make('unidade.simbolo')
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
            'Un. Medida' => $record->unidade->simbolo,
        ];
    }
}
