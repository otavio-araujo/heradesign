<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Models\CategoriaConta;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CategoriaContaResource\Pages;
use App\Filament\Resources\CategoriaContaResource\RelationManagers;

class CategoriaContaResource extends Resource
{
    protected static ?string $model = CategoriaConta::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Financeiro';

    protected static ?int $navigationSort = 12;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $recordTitleAttribute = 'nome';

    protected static ?string $navigationLabel = 'Categorias de Contas';
    
    protected static ?string $slug = 'categorias-de-contas';

    protected static ?string $label = 'Categoria de Conta';

    protected static ?string $pluralLabel = 'Categorias de Contas';

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
                        
                        Select::make('plano_conta_id')
                            ->relationship('planoConta', 'nome')
                            ->required()
                            ->searchable()
                            ->preload(true)
                            ->columnSpan(12)
                        ,

                        TextInput::make('nome')
                            ->autofocus()    
                            ->label('Nome da Categoria da Conta')
                            ->unique(CategoriaConta::class, 'nome', fn ($record) => $record)
                            ->required()
                            ->columnSpan(12)
                        ,
    
    
                    ])->columnSpan([
                            'md' => 2,
                            'lg' => 3,
                            'xl' => 4,
                        ])
                        ->columns(12)
                    ,
    
                    Section::make('Alterações')->schema([
    
                        Placeholder::make('created_at')
                            ->label('Data do cadastro')
                            ->content(fn (?CategoriaConta $record): string => $record ? $record->created_at->diffForHumans() : '-'),
    
                        Placeholder::make('updated_at')
                            ->label('Última atualização')
                            ->content(fn (?CategoriaConta $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
    
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
            ->columns([
                
                TextColumn::make('planoConta.nome')->label('Plano de Conta'),
                TextColumn::make('nome')->label('Categoria da Conta'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->tooltip('Editar Categoria')
                    ->label('')
                    ->color('warning')
                    ->icon('heroicon-o-pencil')
                    ->size('lg')
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListCategoriaContas::route('/'),
            'create' => Pages\CreateCategoriaConta::route('/create'),
            'edit' => Pages\EditCategoriaConta::route('/{record}/edit'),
        ];
    }    
}
