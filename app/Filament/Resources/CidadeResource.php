<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Cidade;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\CidadeResource\Pages;
use App\Filament\Resources\CidadeResource\RelationManagers;
use App\Models\Estado;

class CidadeResource extends Resource
{
    protected static ?string $model = Cidade::class;

    protected static ?string $navigationIcon = 'heroicon-o-location-marker';

    protected static ?string $navigationGroup = 'Cadastros Auxiliares';

    protected static ?int $navigationSort = 101;

    protected static ?string $recordTitleAttribute = 'nome';

    protected static ?string $navigationLabel = 'Cidades';
    
    protected static ?string $slug = 'cidades';

    protected static ?string $label = 'Cidade';

    protected static ?string $pluralLabel = 'Cidades';

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
    
                    Section::make('Dados Básicos')->schema([
                        
                        Forms\Components\TextInput::make('nome')
                            ->label('Nome da Cidade')
                            ->required()
                            ->unique(ignorable: fn (?Model $record): ?Model => $record)
                            ->maxLength(50)
                        ,
    
                        Select::make('estado_id')
                            ->label('Estado')
                            ->searchable()
                            ->getSearchResultsUsing(fn (string $searchQuery) => Estado::where('nome', 'like', "%{$searchQuery}%")->limit(50)->pluck('nome', 'id'))
                            ->getOptionLabelUsing(fn ($value): ?string => Estado::find($value)?->nome)
                        ,
    
                    ])->columnSpan([
                            'md' => 2,
                            'lg' => 3,
                            'xl' => 4,
                        ]),
    
                    Section::make('Alterações')->schema([
    
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Data do cadastro')
                            ->content(fn (?Cidade $record): string => $record ? $record->created_at->diffForHumans() : '-'),
    
                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Última atualização')
                            ->content(fn (?Cidade $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
    
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
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCidades::route('/'),
            'create' => Pages\CreateCidade::route('/create'),
            'edit' => Pages\EditCidade::route('/{record}/edit'),
        ];
    }

    public static function getTableColumns(): array
    {
        return [

            Tables\Columns\TextColumn::make('nome')
                ->label('Nome da Cidade')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('estado.uf')
                ->label('UF')
                ->searchable()
                ->sortable(),
                
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['nome', 'estado.uf'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        
        
        return [
            'Cidade' => $record->nome,
            'UF' => $record->estado->uf,
        ];
    }
}
