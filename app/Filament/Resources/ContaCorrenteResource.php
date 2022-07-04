<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use App\Models\ContaCorrente;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput\Mask;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ContaCorrenteResource\Pages;
use App\Filament\Resources\ContaCorrenteResource\RelationManagers;

class ContaCorrenteResource extends Resource
{
    protected static ?string $model = ContaCorrente::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive';

    protected static ?string $navigationGroup = 'Financeiro';

    protected static ?int $navigationSort = 10;

    protected static ?string $recordTitleAttribute = 'banco';

    protected static ?string $navigationLabel = 'Contas Correntes';
    
    protected static ?string $slug = 'contas-correntes';

    protected static ?string $label = 'Conta Corrente';

    protected static ?string $pluralLabel = 'Contas Correntes';

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
                        
                        TextInput::make('titular')
                            ->autofocus()    
                            ->label('Titular da Conta')
                            ->required()
                            ->default('HERA DESIGN')
                            ->columnSpan(12)
                        ,

                        TextInput::make('banco')
                            ->autofocus()    
                            ->label('Nome do Banco')
                            ->required()
                            ->columnSpan([
                                'md' => 12,
                                'lg' => 12,
                                'xl' => 12,
                            ])
                        ,

                        TextInput::make('agencia')
                            ->autofocus()    
                            ->label('Número da Agência')
                            ->required()
                            ->columnSpan([
                                'md' => 6,
                            ])
                        ,
    

                        TextInput::make('conta')
                            ->autofocus()    
                            ->label('Número da Conta')
                            ->required()
                            ->columnSpan([
                                'md' => 6,
                            ])
                        ,

                        TextInput::make('saldo_inicial')
                            ->mask(fn (Mask $mask) => $mask
                                ->patternBlocks([
                                    'money' => fn (Mask $mask) => $mask
                                        ->numeric()
                                        ->decimalPlaces(2)
                                        ->mapToDecimalSeparator([',', '.'])
                                        ->thousandsSeparator('.')
                                        ->decimalSeparator(',')
                                        ->normalizeZeros(false)
                                        ->padFractionalZeros(false)
                                    ,
                                ])
                                ->pattern('R$ money')
                                ->lazyPlaceholder(false),
                            )
                            ->columnSpan([
                                'default' => 12,
                                'md' => 6,
                            ])
                        ,

                        TextInput::make('saldo_atual')
                            ->mask(fn (Mask $mask) => $mask
                                ->patternBlocks([
                                    'money' => fn (Mask $mask) => $mask
                                        ->numeric()
                                        ->decimalPlaces(2)
                                        ->mapToDecimalSeparator([',', '.'])
                                        ->thousandsSeparator('.')
                                        ->decimalSeparator(',')
                                        ->normalizeZeros(false)
                                        ->padFractionalZeros(false)
                                    ,
                                ])
                                ->pattern('R$ money')
                                ->lazyPlaceholder(false),
                            )
                            ->columnSpan([
                                'default' => 12,
                                'md' => 6,
                            ])
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
                            ->content(fn (?ContaCorrente $record): string => $record ? $record->created_at->diffForHumans() : '-'),
    
                        Placeholder::make('updated_at')
                            ->label('Última atualização')
                            ->content(fn (?ContaCorrente $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
    
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
                TextColumn::make('titular'),
                TextColumn::make('banco'),
                TextColumn::make('agencia'),
                TextColumn::make('conta'),
                TextColumn::make('saldo_inicial')
                    ->formatStateUsing(fn (string $state): string => 'R$' . number_format($state, 2, ',', '.')),
                TextColumn::make('saldo_atual')
                    ->formatStateUsing(fn (string $state): string => 'R$' . number_format($state, 2, ',', '.')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->tooltip('Editar Conta Corrente')
                    ->label('')
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
            'index' => Pages\ListContaCorrentes::route('/'),
            'create' => Pages\CreateContaCorrente::route('/create'),
            'edit' => Pages\EditContaCorrente::route('/{record}/edit'),
        ];
    }    
}
