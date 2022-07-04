<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use App\Models\FeedstockType;
use Filament\Resources\Table;
use App\Models\ProposalStatus;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use App\Filament\Resources\ProposalStatusResource\Pages;
use App\Filament\Resources\ProposalStatusResource\RelationManagers;
use App\Filament\Resources\ProposalStatusResource\Pages\EditProposalStatus;
use App\Filament\Resources\ProposalStatusResource\Pages\CreateProposalStatus;
use App\Filament\Resources\ProposalStatusResource\Pages\ListProposalStatuses;

class ProposalStatusResource extends Resource
{
    protected static ?string $model = ProposalStatus::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Cadastros Auxiliares';

    protected static ?int $navigationSort = 40;

    protected static ?string $recordTitleAttribute = 'nome';

    protected static ?string $navigationLabel = 'Status de Propostas';
    
    protected static ?string $slug = 'status-de-propostas';

    protected static ?string $label = 'Status de Proposta';

    protected static ?string $pluralLabel = 'Status de Propostas';

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
    
                    Section::make('Status de Proposta')->schema([
                        
                        TextInput::make('nome')
                            ->autofocus()
                            ->label('Nome')
                            ->required()
                            ->unique(ProposalStatus::class, 'nome', fn ($record) => $record)
                            ->maxLength(50)
                            ->columnSpan([
                                'default' => 12,
                            ])
                        ,
    
                    ])->columnSpan([
                            'md' => 3,
                            'lg' => 4,
                            'xl' => 8,
                        ])->columns([
                                'md' => 12,
                            ]),
    
                ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                BadgeColumn::make('nome')
                    ->colors([
                        'primary' => 'Nova',
                        'danger' => 'Reprovada',
                        'warning' => 'Em Análise',
                        'success',
                        
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->tooltip('Editar Estatus de Propostas')
                    ->label('')
                    ->icon('heroicon-o-pencil')
                    ->size('lg'),
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
            'index' => Pages\ListProposalStatuses::route('/'),
            'create' => Pages\CreateProposalStatus::route('/create'),
            'edit' => Pages\EditProposalStatus::route('/{record}/edit'),
        ];
    }
}
