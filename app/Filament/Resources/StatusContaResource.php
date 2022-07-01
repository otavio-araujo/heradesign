<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\StatusConta;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StatusContaResource\Pages;
use App\Filament\Resources\StatusContaResource\RelationManagers;

class StatusContaResource extends Resource
{
    protected static ?string $model = StatusConta::class;

    protected static ?string $navigationIcon = 'heroicon-o-badge-check';

    protected static ?string $navigationGroup = 'Financeiro';

    protected static ?int $navigationSort = 15;

    protected static ?string $recordTitleAttribute = 'nome';

    protected static ?string $navigationLabel = 'Status de Pagamentos';
    
    protected static ?string $slug = 'status-de-pagamentos';

    protected static ?string $label = 'Status de Pagamento';

    protected static ?string $pluralLabel = 'Status de Pagamentos';

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
                        
                        TextInput::make('nome')
                            ->autofocus()    
                            ->label('Status de Pagamento')
                            ->unique(StatusConta::class, 'nome', fn ($record) => $record)
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
                            ->content(fn (?StatusConta $record): string => $record ? $record->created_at->diffForHumans() : '-'),
    
                        Placeholder::make('updated_at')
                            ->label('Última atualização')
                            ->content(fn (?StatusConta $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
    
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
                TextColumn::make('nome')->label('Status de Pagamento'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->tooltip('Editar Status de Pagamento')
                    ->label('')
                    ->color('warning')
                    ->icon('heroicon-o-pencil')
                    ->size('lg'),
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
            'index' => Pages\ListStatusContas::route('/'),
            'create' => Pages\CreateStatusConta::route('/create'),
            'edit' => Pages\EditStatusConta::route('/{record}/edit'),
        ];
    }    
}
