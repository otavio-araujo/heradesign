<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use Filament\Tables;
use App\Helpers\Helpers;
use App\Models\Transaction;
use Filament\Resources\Form;
use App\Models\ContaCorrente;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Pages\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\MultiSelectFilter;
use Illuminate\Console\Scheduling\CallbackEvent;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TransactionResource\Pages;
use Webbingbrasil\FilamentAdvancedFilter\Filters\DateFilter;
use App\Filament\Resources\TransactionResource\RelationManagers;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-switch-horizontal';

    protected static ?string $navigationGroup = 'Financeiro';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?string $navigationLabel = 'Fluxo de Caixa';
    
    protected static ?string $slug = 'fluxo-de-caixa';

    protected static ?string $label = 'Fluxo de Caixa';

    protected static ?string $pluralLabel = 'Fluxo de Caixa';

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

                TextColumn::make('blank')
                    ->label('')
                ,

                ViewColumn::make('operacao')
                    ->label('Operação')
                    ->view('filament.tables.columns.transaction-tipo-conta')
                ,

                TextColumn::make('descricao')
                    ->label('Descrição')
                    ->wrap()
                    ->formatStateUsing(fn (Model $record): String => ($record->conta_pagar_id === null ? $record->contaReceber->descricao : $record->contaPagar->descricao))
                    ->extraAttributes(['class' => 'text-xs'])
                ,

                ViewColumn::make('pago_em')
                    ->label('Pago/Recebido')
                    ->view('filament.tables.columns.transaction-pago-em')
                ,

                ViewColumn::make('liquidado_em')
                    ->label('Liquidado')
                    ->view('filament.tables.columns.transaction-liquidado-em')
                    ->sortable()
                ,

                ViewColumn::make('vencimento_em')
                    ->label('Vencimento')
                    ->view('filament.tables.columns.transaction-vencimento-em')
                ,

                ViewColumn::make('valor')
                    ->label('Valor')
                    ->view('filament.tables.columns.transaction-valor')
                ,
            ])

            ->defaultSort('liquidado_em', 'desc')

            ->filters([

                Filter::make('liquidado_em')
                    ->form([


                        Fieldset::make('Período de Pesquisa')
                        ->schema([
                            Forms\Components\DatePicker::make('liquidado_em')
                                ->displayFormat('d/m/Y')
                                ->default(now()->subDays(7))
                                ->columnSpan(3)
                            ,
                            Forms\Components\DatePicker::make('liquidado_ate')
                                ->default(now())
                                ->displayFormat('d/m/Y')
                                ->columnSpan(3)
                            ,
                        ])
                        
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['liquidado_em'],
                                fn (Builder $query, $date): Builder => $query->whereDate('liquidado_em', '>=', $date),
                            )
                            ->when(
                                $data['liquidado_ate'],
                                fn (Builder $query, $date): Builder => $query->whereDate('liquidado_em', '<=', $date), 
                            );
                    })
                , 
                
                Filter::make('operacoes')
                    ->form([

                        Fieldset::make('Operações')
                            ->schema([
                                Forms\Components\Checkbox::make('conta_pagar_id')
                                    ->label('Despesas')
                                    ->columnSpan(3)
                                    ->reactive()
                                    ->afterStateUpdated(fn (callable $set) => $set('conta_receber_id', null))
                                ,
                                Forms\Components\Checkbox::make('conta_receber_id')
                                    ->label('Receitas')
                                    ->columnSpan(3)
                                    ->reactive()
                                    ->afterStateUpdated(fn (callable $set) => $set('conta_pagar_id', null))
                                ,
                            ])
                            
                        ])
                        ->query(function (Builder $query, array $data): Builder {
                            return $query
                                ->when(
                                    $data['conta_pagar_id'] != null,
                                    fn (Builder $query): Builder => $query->whereNotNull('conta_pagar_id'),
                                )
                                ->when(
                                    $data['conta_receber_id'] != null,
                                    fn (Builder $query): Builder => $query->whereNotNull('conta_receber_id'), 
                                );
                        })
                , 

                MultiSelectFilter::make('conta_corrente_id')
                    ->label('Conta Corrente')
                    ->options(ContaCorrente::all()->pluck('banco', 'id'))
                    ->column('conta_corrente_id')    
                ,

            ])

            ->actions([
                // Tables\Actions\EditAction::make(),
            ])

            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }  
    
}
