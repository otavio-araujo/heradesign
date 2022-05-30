<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Supplier;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\SupplierResource\Pages;
use App\Filament\Resources\SupplierResource\RelationManagers;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;

    protected static ?string $navigationLabel = 'Fornecedores';
    
    protected static ?string $slug = 'fornecedores';

    protected static ?string $label = 'Fornecedor';

    protected static ?string $pluralLabel = 'Fornecedores';

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $recordTitleAttribute = 'nome';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Contato')
                    ->schema([
                        Forms\Components\TextInput::make('nome')
                            ->required()
                            ->maxLength(150)
                            ->columnSpan([
                                'lg' => 5,
                            ]),
                        Forms\Components\TextInput::make('cnpj')
                            ->unique(Fornecedor::class, 'cnpj', fn ($record) => $record)
                            ->mask(fn (TextInput\Mask $mask) => $mask->pattern('00.000.000/0000-00'))
                            ->columnSpan([
                                'lg' => 3,
                            ]),
            
                        Forms\Components\TextInput::make('contato')
                            ->label('Contato')
                            ->maxLength(15)
                            ->columnSpan([
                                'lg' => 2,
                            ]),
                        Forms\Components\TextInput::make('whatsapp')
                            ->maxLength(15)
                            ->mask(fn (TextInput\Mask $mask) => $mask->pattern('(00) 00000-0000'))
                            ->columnSpan([
                                'lg' => 2,
                            ]),
                        Forms\Components\TextInput::make('telefone')
                            ->maxLength(15)
                            ->mask(fn (TextInput\Mask $mask) => $mask->pattern('(00) 0000-0000'))
                            ->columnSpan([
                                'lg' => 2,
                            ]),
                            
                        Forms\Components\TextInput::make('celular')
                            ->maxLength(15)
                            ->mask(fn (TextInput\Mask $mask) => $mask->pattern('(00) 00000-0000'))
                            ->columnSpan([
                                'lg' => 2,
                            ]),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255)->columnSpan([
                                'lg' => 8,
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
                                ->content(fn (?Supplier $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                            Forms\Components\Placeholder::make('updated_at')
                                ->label('Última atualização')
                                ->content(fn (?Supplier $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                        ])
                    ->columnSpan(3),

                    Section::make('Endereço')
                    ->schema([
                        Forms\Components\TextInput::make('cep')
                            ->maxLength(9)
                            ->mask(fn (TextInput\Mask $mask) => $mask->pattern('00000-000'))
                            ->columnSpan([
                                'lg' => 3,
                            ]),
                        Forms\Components\TextInput::make('endereco')
                            ->maxLength(255)
                            ->columnSpan([
                                'lg' => 5,
                            ]),
                        Forms\Components\TextInput::make('bairro')
                            ->maxLength(150)
                            ->columnSpan([
                                'lg' => 3,
                            ]),
                        Forms\Components\TextInput::make('cidade')
                            ->maxLength(150)
                            ->columnSpan([
                                'lg' => 4,
                            ]),
                        Forms\Components\TextInput::make('uf')
                            ->maxLength(2),
                       
                       
                        Forms\Components\TextInput::make('numero')
                            ->maxLength(10)
                            ->mask(fn (TextInput\Mask $mask) => $mask->pattern('0000000000'))
                            ->columnSpan([
                                'lg' => 3,
                            ]),
                        Forms\Components\TextInput::make('complemento')
                            ->maxLength(100)
                            ->columnSpan([
                                'lg' => 5,
                            ]),

                    ])
                    ->columns([
                        'md' => 8,
                    ])
                    ->columnSpan([
                        'md' => 9,
                    ]),
            ])
            ->columns([
                'md' => 12,
                'lg' => null,
            ]);
    }

    public static function table(Table $table): Table
    {
        
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome'),
                Tables\Columns\TextColumn::make('contato'),
                Tables\Columns\TextColumn::make('telefone'),
                Tables\Columns\TextColumn::make('celular'),
                Tables\Columns\TextColumn::make('whatsapp'),
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
            'index' => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),
            'edit' => Pages\EditSupplier::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['nome_fantasia', 'cidade', 'contato'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        
        
        return [
            'Contato' => $record->contato,
            'Whatsapp' => $record->whatsapp,
        ];
    }

}
