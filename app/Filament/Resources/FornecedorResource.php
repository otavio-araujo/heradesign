<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FornecedorResource\Pages;
use App\Filament\Resources\FornecedorResource\RelationManagers;
use App\Forms\Components\AddressForm;
use App\Models\Fornecedor;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Squire\Models\Country;

class FornecedorResource extends Resource
{
    protected static ?string $model = Fornecedor::class;

    protected static ?string $title = 'Fornecedores';

    protected static ?string $navigationLabel = 'Fornecedores';
    
    protected static ?string $slug = 'fornecedores';

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $recordTitleAttribute = 'nome_fantasia';
 
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('nome_fantasia')
                            ->required()
                            ->maxLength(150)
                            ->columnSpan([
                                'lg' => 5,
                                'md' => 4,
                            ]),
                        Forms\Components\TextInput::make('cnpj')
                            ->unique(Fornecedor::class, 'cnpj', fn ($record) => $record)
                            ->columnSpan([
                                'lg' => 3,
                                'md' => 4,
                            ]),
            
                        Forms\Components\TextInput::make('responsavel')
                            ->label('Contato')
                            ->tel()
                            ->maxLength(15)
                            ->columnSpan([
                                'lg' => 2,
                            ]),
                        Forms\Components\TextInput::make('whatsapp')
                            ->maxLength(15)
                            ->columnSpan([
                                'lg' => 2,
                            ]),
                        Forms\Components\TextInput::make('telefone')
                            ->maxLength(15)
                            ->columnSpan([
                                'lg' => 2,
                            ]),
                            
                            Forms\Components\TextInput::make('celular')
                            ->maxLength(15)
                            ->columnSpan([
                                'lg' => 2,
                            ]),
                    ])
                    ->columns([
                        'md' => 8,
                    ])
                    ->columnSpan([
                        'md' => 6,
                    ]),
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Data do cadastro')
                            ->content(fn (?Fornecedor $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Última atualização')
                            ->content(fn (?Fornecedor $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                    ])
                    ->columnSpan(2),
            ])
            ->columns([
                'md' => 8,
                'lg' => null,
            ]);
        /* return $form
            ->schema([
                Forms\Components\TextInput::make('nome_fantasia')
                    ->required()
                    ->maxLength(150),
                Forms\Components\TextInput::make('cnpj')
                    ->maxLength(15),
                Forms\Components\TextInput::make('cep')
                    ->maxLength(9),
                Forms\Components\TextInput::make('endereco')
                    ->maxLength(255),
                Forms\Components\TextInput::make('numero'),
                Forms\Components\TextInput::make('complemento')
                    ->maxLength(100),
                Forms\Components\TextInput::make('bairro')
                    ->maxLength(150),
                Forms\Components\TextInput::make('cidade')
                    ->maxLength(150),
                Forms\Components\TextInput::make('uf')
                    ->maxLength(2),
                    Forms\Components\TextInput::make('telefone')
                        ->tel()
                        ->maxLength(15),
                    Forms\Components\TextInput::make('celular')
                        ->maxLength(15),
                    Forms\Components\TextInput::make('whatsapp')
                        ->maxLength(15),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('responsavel')
                    ->maxLength(150),
            ]); */
    }

    public static function table(Table $table): Table
    {
        
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome_fantasia'),
                Tables\Columns\TextColumn::make('responsavel'),
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
            'index' => Pages\ListFornecedors::route('/'),
            'create' => Pages\CreateFornecedor::route('/create'),
            'edit' => Pages\EditFornecedor::route('/{record}/edit'),
        ];
    }
}
