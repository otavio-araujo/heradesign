<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Models\FormaPagamento;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FormaPagamentoResource\Pages;
use App\Filament\Resources\FormaPagamentoResource\RelationManagers;

class FormaPagamentoResource extends Resource
{
    protected static ?string $model = FormaPagamento::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Financeiro';

    protected static ?int $navigationSort = 20;

    protected static ?string $recordTitleAttribute = 'nome';

    protected static ?string $navigationLabel = 'Formas de Pagamento';
    
    protected static ?string $slug = 'formas-de-pagamentos';

    protected static ?string $label = 'Forma de Pagamento';

    protected static ?string $pluralLabel = 'Formas de Pagamento';

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
                            ->label('Forma de Pagamento')
                            ->unique(FormaPagamento::class, 'nome', fn ($record) => $record)
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
                            ->content(fn (?FormaPagamento $record): string => $record ? $record->created_at->diffForHumans() : '-'),
    
                        Placeholder::make('updated_at')
                            ->label('Última atualização')
                            ->content(fn (?FormaPagamento $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
    
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
                TextColumn::make('nome')->label('Forma de Pagamento'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->tooltip('Editar Forma de Pagamento')
                    ->label('')
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
            'index' => Pages\ListFormaPagamentos::route('/'),
            'create' => Pages\CreateFormaPagamento::route('/create'),
            'edit' => Pages\EditFormaPagamento::route('/{record}/edit'),
        ];
    }    
}
