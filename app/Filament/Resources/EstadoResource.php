<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Estado;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\EstadoResource\Pages;
use App\Filament\Resources\EstadoResource\RelationManagers;

class EstadoResource extends Resource
{
    protected static ?string $model = Estado::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static ?string $navigationGroup = 'Cadastros Auxiliares';

    protected static ?int $navigationSort = 100;

    protected static ?string $recordTitleAttribute = 'nome';

    protected static ?string $navigationLabel = 'Estados';
    
    protected static ?string $slug = 'estados';

    protected static ?string $label = 'Estado';

    protected static ?string $pluralLabel = 'Estados';

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

                Section::make('Dados Básicos')->schema([
                    
                    Forms\Components\TextInput::make('nome')
                        ->label('Nome do Estado')
                        ->required()
                        ->unique()
                        ->maxLength(50)
                        ->columnSpan([
                            'md' => 3,
                        ])
                    ,

                    Forms\Components\TextInput::make('uf')
                        ->label('UF')
                        ->required()
                        ->unique()
                        ->maxLength(2)
                        ->columnSpan([
                            'md' => 1,
                        ])
                    ,

                ])->columnSpan([
                        'md' => 2,
                        'lg' => 3,
                        'xl' => 4,
                    ])->columns([
                            'md' => 4,
                        ]),

                Section::make('Alterações')->schema([

                    Forms\Components\Placeholder::make('created_at')
                        ->label('Data do cadastro')
                        ->content(fn (?Estado $record): string => $record ? $record->created_at->diffForHumans() : '-'),

                    Forms\Components\Placeholder::make('updated_at')
                        ->label('Última atualização')
                        ->content(fn (?Estado $record): string => $record ? $record->updated_at->diffForHumans() : '-'),

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
            RelationManagers\CidadesRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEstados::route('/'),
            'create' => Pages\CreateEstado::route('/create'),
            'edit' => Pages\EditEstado::route('/{record}/edit'),
        ];
    }

    public static function getTableColumns(): array
    {
        return [

            Tables\Columns\TextColumn::make('nome')
                ->label('Nome do Estado')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('uf')
                ->label('UF')
                ->searchable()
                ->sortable(),
                
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['nome', 'uf'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        
        
        return [
            'Estado' => $record->nome,
            'UF' => $record->uf,
        ];
    }
}
