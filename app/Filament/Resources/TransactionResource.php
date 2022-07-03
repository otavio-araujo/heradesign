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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\MultiSelectFilter;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Financeiro';

    protected static ?int $navigationSort = 2;

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

                TextColumn::make('contaReceber.order.id')
                    ->label('Pedido Nº')
                    ->formatStateUsing(fn (Transaction $record) => Helpers::setProposalNumber($record->contaReceber->order->id))
                ,

                ViewColumn::make('contaReceber.pago_em')
                    ->label('Pago')
                    ->view('filament.tables.columns.transaction-pago-em')
                ,

                ViewColumn::make('contaReceber.liquidado_em')
                    ->label('Liquidado')
                    ->view('filament.tables.columns.transaction-liquidado-em')
                ,

                ViewColumn::make('contaReceber.vencimento_em')
                    ->label('Vencimento')
                    ->view('filament.tables.columns.transaction-vencimento-em')
                ,

                TextColumn::make('contaReceber.descricao')
                    ->label('Descrição')
                    ->wrap()
                    ->extraAttributes(['class' => 'text-xs'])
                ,

                ViewColumn::make('valor')
                    ->label('Valor')
                    ->view('filament.tables.columns.transaction-valor')
                ,
            ])
            ->filters([
                MultiSelectFilter::make('conta_corrente_id')
                    ->label('Conta Corrente')
                    ->options(ContaCorrente::all()->pluck('banco', 'id'))
                    ->column('conta_corrente_id')    
                ,

                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('liquidado_em'),
                        Forms\Components\DatePicker::make('liquidado_ate'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->join('contas_receber', 'transactions.id', 'contas_receber.id')
                            ->when(
                                $data['liquidado_em'],
                                fn (Builder $query, $date): Builder => $query->whereDate('contas_receber.liquidado_em', '>=', $date),
                            )
                            ->when(
                                $data['liquidado_ate'],
                                fn (Builder $query, $date): Builder => $query->whereDate('contas_receber.liquidado_em', '<=', $date), 
                            );
                    })
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
