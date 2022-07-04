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
                MultiSelectFilter::make('conta_corrente_id')
                    ->label('Conta Corrente')
                    ->options(ContaCorrente::all()->pluck('banco', 'id'))
                    ->column('conta_corrente_id')    
                ,

                Filter::make('liquidado_em')
                    ->form([
                        Forms\Components\DatePicker::make('liquidado_em'),
                        Forms\Components\DatePicker::make('liquidado_ate'),
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
