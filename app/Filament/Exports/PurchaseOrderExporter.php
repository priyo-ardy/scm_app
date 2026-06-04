<?php

namespace App\Filament\Exports;

use App\Models\PurchaseOrderView;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class PurchaseOrderExporter extends Exporter
{
    protected static ?string $model = PurchaseOrderView::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('code')->label('Document No.'),
            ExportColumn::make('doc_date')->label('Document Date')->formatStateUsing(fn($state) => $state ? date('d/M/Y', strtotime($state)) : '-'),
            ExportColumn::make('doc_status')->label('Document Status')->formatState(fn($state) => $state ? ucwords($state) : '-'),
            ExportColumn::make('is_closed')->label('Closed Status')->formatState(fn($state) => $state ? 'Closed' : 'Unclosed'),
            ExportColumn::make('supplier_name')->label('Supplier Name'),
            ExportColumn::make('department_name')->label('Requested Department'),
            ExportColumn::make('currency_name')->label('Currency'),
            ExportColumn::make('exchange_rate')->label('Exchange Rate')->formatStateUsing(fn($state) => $state ? number_format($state) : 1),
            ExportColumn::make('payment_term')->label('Payment Term'),
            ExportColumn::make('shipping_address')->label('Shipping Address'),
            ExportColumn::make('remark')->label('Remark'),
            ExportColumn::make('material_code')->label('Material Code'),
            ExportColumn::make('material_name')->label('Material Name'),
            ExportColumn::make('specification')->label('Specification'),
            ExportColumn::make('qty')->label('Qty')->formatStateUsing(fn($state) => $state ? number_format($state, 4) : 0),,
            ExportColumn::make('qty_remaining')->label('Qty Remaining')->formatStateUsing(fn($state) => $state ? number_format($state, 4) : 0),
            ExportColumn::make('unit_price')->label('Unit Price')->formatStateUsing(fn($state) => $state ? number_format($state, 4) : 0),,
            ExportColumn::make('discount_rate')->label('Discount Rate')->formatStateUsing(fn($state) => $state ? number_format($state, 4) : 0),,
            ExportColumn::make('discount_amount')->label('Discount Amount')->formatStateUsing(fn($state) => $state ? number_format($state, 4) : 0),,
            ExportColumn::make('price_after_discount')->label('Price After Discount')->formatStateUsing(fn($state) => $state ? number_format($state, 4) : 0),,
            ExportColumn::make('tax_rate')->label('Tax Rate')->formatStateUsing(fn($state) => $state ? number_format($state, 4) : 0),,
            ExportColumn::make('tax_amount')->label('Tax Amount')->formatStateUsing(fn($state) => $state ? number_format($state, 4) : 0),,
            ExportColumn::make('price_after_tax')->label('Price After Tax')->formatStateUsing(fn($state) => $state ? number_format($state, 4) : 0),,
            ExportColumn::make('total_amount')->label('Total Amount')->formatStateUsing(fn($state) => $state ? number_format($state, 4) : 0),,
            ExportColumn::make('row_status')->label('Row Status'),
            ExportColumn::make('row_closed')->label('Closed by Row'),
            ExportColumn::make('remark_detail')->label('Remark'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your purchase order export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }


    public function getFileName(Export $export): string
    {
        return 'purchase_order_list_' . now()->format('YmdHis');
    }
}
