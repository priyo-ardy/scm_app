<?php

namespace App\Filament\Resources\PurchaseOrders\Tables;

use App\Filament\Exports\PurchaseOrderExporter;
use App\Models\Currency;
use App\Models\Department;
use App\Models\Material;
use App\Models\PaymentTerm;
use App\Models\PurchaseOrderHeader;
use App\Models\Unit;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\QueryBuilder\Constraints\DateConstraint;
use Filament\QueryBuilder\Constraints\NumberConstraint;
use Filament\QueryBuilder\Constraints\SelectConstraint;
use Filament\QueryBuilder\Constraints\TextConstraint;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

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
                    ->formatStateUsing(fn($state) => date('d/M/Y', strtotime($state))),
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
            ->recordUrl(function ($record) {
                return route('filament.admin.resources.purchase-orders.view', [
                    'record' => $record->po_id
                ]);
            })
            ->filters([
                QueryBuilder::make()
                    ->constraints([
                        TextConstraint::make('header.code')
                            ->label('Purcase Order No.'),
                        TextConstraint::make('header.remark')
                            ->label('Remark'),
                        DateConstraint::make('header.doc_date')
                            ->label('PO Date.'),
                        DateConstraint::make('arrival_date')
                            ->label('Arrival Date'),
                        SelectConstraint::make('header.supplier.id')
                            ->label('Supplier')
                            ->options(fn() => PurchaseOrderHeader::where('is_active', true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray())
                            ->searchable()
                            ->native(false),
                        SelectConstraint::make('header.currency_id')
                            ->label('Currency')
                            ->options(fn() => Currency::where('is_active', true)->orderBy('code', 'asc')->pluck('code', 'id')->toArray())
                            ->searchable()
                            ->native(false),
                        SelectConstraint::make('header.doc_status')
                            ->label('Document Status')
                            ->options([
                                'saved' => 'Saved',
                                'approved' => 'Approved',
                                'hold' => 'Hold',
                                'rejected' => 'Rejected',
                                'closed' => 'Closed',
                            ])
                            ->searchable()
                            ->native(false),
                        SelectConstraint::make('header.is_closed')
                            ->label('Closed Status')
                            ->options([
                                '0' => 'Unclosed',
                                '1' => 'Closed'
                            ])
                            ->searchable()
                            ->native(false),
                        SelectConstraint::make('header.department_id')
                            ->label('Requsted Department')
                            ->options(fn() => Department::where('is_active', true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray())
                            ->searchable()
                            ->native(false),
                        SelectConstraint::make('header.payment_term_id')
                            ->label('Payment Term')
                            ->options(fn() => PaymentTerm::where('is_active', true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray())
                            ->searchable()
                            ->native(false),
                        SelectConstraint::make('material_id')
                            ->label('Material')
                            ->options(fn() => Material::where('is_active', true)->orderBy('code', 'asc')->pluck('code', 'id')->toArray())
                            ->searchable()
                            ->native(false),
                        SelectConstraint::make('unit_id')
                            ->label('UoM')
                            ->options(fn() => Unit::where('is_active', true)->orderBy('code', 'asc')->pluck('code', 'id')->toArray())
                            ->searchable()
                            ->native(false),
                        SelectConstraint::make('row_status')
                            ->label('Row Status')
                            ->options([
                                'open' => 'Open',
                                'partial' => 'Partial',
                                'closed' => 'Closed'
                            ])
                            ->searchable()
                            ->native(false),
                        SelectConstraint::make('is_closed')
                            ->label('Closed By Row')
                            ->options([
                                '0' => 'No',
                                '1' => 'Yes'
                            ])
                            ->searchable()
                            ->native(false),
                        NumberConstraint::make('qty')
                            ->label('Qty'),
                        NumberConstraint::make('qty_remaining')
                            ->label('Qty Remaining'),
                        NumberConstraint::make('unit_price')
                            ->label('Unit Price'),
                        NumberConstraint::make('amount')
                            ->label('Amount'),
                        NumberConstraint::make('discount_rate')
                            ->label('Discount Rate (%)'),
                        NumberConstraint::make('discount_amount')
                            ->label('Discount Amount'),
                        NumberConstraint::make('price_after_discount')
                            ->label('Price After Discount'),
                        NumberConstraint::make('tax_rate')
                            ->label('Tax Rate(%)'),
                        NumberConstraint::make('tax_amount')
                            ->label('Tax Amount'),
                        NumberConstraint::make('price_after_tax')
                            ->label('Price After Tax'),
                        NumberConstraint::make('total_amount')
                            ->label('Total Amount')
                    ])
                    ->constraintPickerColumns(3)
            ], layout: FiltersLayout::Modal)
            ->filtersFormColumns(2)
            ->filtersFormWidth('4xl')
            ->persistFiltersInSession()
            ->filtersTriggerAction(
                fn($action) => $action
                    ->button()
                    ->label('Filter')
                    ->icon(Heroicon::OutlinedFunnel)
            )
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
                Action::make('refresh')
                    ->label('Refresh')
                    ->button()
                    ->tooltip('Refresh')
                    ->icon(Heroicon::OutlinedArrowPath)
                    ->action(fn() => null),
                ExportAction::make('export')
                    ->label('Export')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->button()
                    ->tooltip('Export')
                    ->exporter(PurchaseOrderExporter::class)
                    ->modifyQueryUsing(function (Builder $query) {
                        return $query
                            ->join('vw_purchase_order', 'purchase_order_details.id', '=', 'vw_purchase_order.id')
                            ->select('vw_purchase_order.*');
                    })
            ]);
    }
}
