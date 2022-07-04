<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Helpers\Helpers;
use App\Models\ContaReceber;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\TextInput\Mask;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ContaReceberResource\Pages;
use App\Filament\Resources\ContaReceberResource\RelationManagers;

class ContaReceberResource extends Resource
{
    protected static ?string $model = ContaReceber::class;

    protected static ?string $navigationIcon = 'heroicon-o-thumb-up';

    protected static ?string $navigationGroup = 'Financeiro';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'descricao';

    protected static ?string $navigationLabel = 'Contas a Receber';
    
    protected static ?string $slug = 'contas-a-receber';

    protected static ?string $label = 'Conta a Receber';

    protected static ?string $pluralLabel = 'Contas a Receber';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('order_id')
                    ->label('Pedido Nº')
                    ->formatStateUsing(fn (ContaReceber $record) => Helpers::setProposalNumber($record->order_id))
                ,

                TextColumn::make('vencimento_em')
                    ->label('Vencimento')
                    ->date('d/m/Y')
                    ->sortable()
                ,

                TextColumn::make('descricao')
                    ->label('Descrição')
                    ->searchable()
                    ->wrap()
                ,

                TextColumn::make('valor_parcela')
                    ->label('Valor da Parcela')
                    ->money('BRL')
                ,

                TextColumn::make('valor_pago')
                    ->label('Total Pago')
                    ->money('BRL')
                ,

                ViewColumn::make('statusConta.nome')
                    ->label('Situação')
                    ->view('filament.tables.columns.status-conta')
                    ->sortable()
                ,
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->tooltip('Editar Conta a Receber')
                    ->label('')
                    ->icon('heroicon-o-pencil')
                    ->size('lg')
                ,

                Tables\Actions\Action::make('baixarConta')
                    ->action('baixarConta', fn (array $data): array => $data)
                    ->tooltip('Baixar Conta a Pagar')
                    ->label('')
                    ->color('success')
                    ->icon('heroicon-o-thumb-up')
                    ->size('lg')
                    ->modalWidth('5xl')
                    ->modalButton('Baixar Conta')
                    ->visible(fn (ContaReceber $record): bool => $record->pago_em == null)
                    ->form([

                        /* BEGIN - Grid */
                        Grid::make([
                            'default' => 1,
                            'sm' => 2,
                            'md' => 3,
                            'lg' => 4,
                            'xl' => 6,
                            '2xl' => 8,
                        ])->schema([
            
                            /* BEGIN - Section - Dados do Faturamento */
                            Section::make(fn (ContaReceber $record): string => $record->customer->nome)->schema([

                                Hidden::make('id')
                                    ->default(fn (ContaReceber $record): string => $record->id)
                                ,
                                
                                TextInput::make('conta_corrente_nome')
                                    ->label('Conta Corrente')
                                    ->default(fn (ContaReceber $record): string => $record->contaCorrente->banco . ' | AG: ' . $record->contaCorrente->agencia . '/ CC: ' . $record->contaCorrente->agencia)
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 4,
                                    ])
                                    ->disabled()
                                ,

                                TextInput::make('plano_conta_nome')
                                    ->label('Plano de Conta')
                                    ->default(fn (ContaReceber $record): string => $record->planoConta->nome)
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 4,
                                    ])
                                    ->disabled()
                                ,

                                TextInput::make('categoria_conta_nome')
                                    ->label('Categoria da Conta')
                                    ->default(fn (ContaReceber $record): string => $record->categoriaConta->nome)
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 4,
                                    ])
                                    ->disabled()
                                ,

                                TextInput::make('valor_previsto')
                                    ->label('Valor do Pedido')
                                    ->default(fn (ContaReceber $record): string => 'R$' . number_format($record->valor_previsto, 2, ',', '.'))
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 2,
                                    ])
                                    ->disabled()
                                ,

                                TextInput::make('valor_parcela')
                                    ->label('Valor da Parcela')
                                    ->default(fn (ContaReceber $record): string => 'R$' . number_format($record->valor_parcela, 2, ',', '.'))
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 2,
                                    ])
                                    ->disabled()
                                ,

                                TextInput::make('parcela_atual')
                                    ->label('Parcela')
                                    ->default(fn (ContaReceber $record): string => $record->parcela_atual . ' DE ' . $record->qtd_parcelas)
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 2,
                                    ])
                                    ->disabled()
                                ,

                                DatePicker::make('vencimento_em')
                                    ->label('Vencimento em')
                                    ->displayFormat('d/m/Y')
                                    ->default(fn (ContaReceber $record): string => Carbon::make($record->vencimento_em)->format('Y-m-d'))
                                    ->disabled()
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 2,
                                    ])
                                ,

                                TextInput::make('documento')
                                    ->label('Documento')
                                    ->default(fn (ContaReceber $record): string => $record->documento)
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 4,
                                    ])
                                    ->disabled()
                                ,

                                
                                DatePicker::make('pago_em')
                                    ->label('Pago em')
                                    ->required()
                                    ->format('Y-m-d')
                                    ->displayFormat('d/m/Y')
                                    ->default(fn (ContaReceber $record): string => Carbon::make($record->vencimento_em)->format('Y-m-d'))
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 3,
                                    ])
                                ,

                                DatePicker::make('liquidado_em')
                                    ->label('Liquidado em')
                                    ->required()
                                    ->format('Y-m-d')
                                    ->displayFormat('d/m/Y')
                                    ->default(fn (ContaReceber $record): string => Carbon::make($record->vencimento_em)->format('Y-m-d'))
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 3,
                                    ])
                                ,

                                TextInput::make('valor_descontos')
                                    ->label('Descontos')
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
                                                ->lazyPlaceholder()
                                            ,
                                        ])
                                        ->pattern('R$ money')
                                    )
                                    ->default(fn (ContaReceber $record): string => $record->valor_descontos)     
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 2,
                                    ])
                                ,

                                TextInput::make('valor_acrescimos')
                                    ->label('Acréscimos')
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
                                                ->lazyPlaceholder()
                                            ,
                                        ])
                                        ->pattern('R$ money')
                                    )
                                    ->default(fn (ContaReceber $record): string => $record->valor_acrescimos)      
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 2,
                                    ])
                                ,

                                TextInput::make('valor_pago')
                                    ->label('Valor Pago')
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
                                                ->lazyPlaceholder()
                                            ,
                                        ])
                                        ->pattern('R$ money')
                                    )
                                    ->default(fn (ContaReceber $record): string => $record->valor_parcela)      
                                    ->columnSpan([
                                        'default' => 'full',
                                        'md' => 2,
                                    ])
                                ,
            
            
                            ])->columnSpan([
                                    'md' => 6,
                            ])
                            ->columns(12),
                            /* END - Section - Dados do Faturamento */
            
                        ])
                        /* END - Grid */
                        
                    ])
                    /* END - Formulario */
                ,
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
            'index' => Pages\ListContaRecebers::route('/'),
            'create' => Pages\CreateContaReceber::route('/create'),
            'edit' => Pages\EditContaReceber::route('/{record}/edit'),
        ];
    }    

}
