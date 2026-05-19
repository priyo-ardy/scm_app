<?php

namespace App\Filament\Resources\PurchaseOrders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class PurchaseOrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company.slug')
                    ->label('Company'),
                TextColumn::make('code')
                    ->label('Doc No.')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('doc_date')
                    ->label('Document Date')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->formatStateUsing(fn($state) => date("d/M/Y", strtotime($state))),
                TextColumn::make('doc_status')
                    ->badge()
                    ->label('Document Status')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->formatStateUsing(fn($state) => ucwords($state))
                    ->color(fn($record) => match ($record->doc_status) {
                        'saved' => 'gray',
                        'approved' => 'success',
                        'hold' => 'warning',
                        'rejected' => 'danger',
                        'closed' => 'primary'
                    })
                    ->alignCenter()
                    ->toggleable(),
                TextColumn::make('is_closed')
                    ->badge()
                    ->label('Close Status')
                    ->formatStateUsing(fn($state) => $state ? 'Closed' : 'Open')
                    ->color(fn($record) => $record->is_closed ? 'primary' : 'success')
                    ->alignCenter()
                    ->toggleable(),
                TextColumn::make('purchaseRequisition.code')
                    ->label('Source Document')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('department.name')
                    ->label('Requested Department')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('supplier.name')
                    ->label('Supplier')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('currency.code')
                    ->label('Currency')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->alignCenter(),
                TextColumn::make('exchange_rate')
                    ->label('Exchange Rate')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn($state) => number_format($state, 4, ',', '.'))
                    ->toggleable()
                    ->alignRight(),
                TextColumn::make('paymentTerm.name')
                    ->label('Payment Term')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('shipping_address')
                    ->label('Shipping Address')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('remark')
                    ->label('Remark')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                // TrashedFilter::make(),
            ])
            ->recordActions([
                // ViewAction::make(),
                // EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
