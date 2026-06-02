<?php

namespace App\Filament\Exports;

use App\Models\PurchaseRequisitionView;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class PurchaseRequisitionExporter extends Exporter
{
    protected static ?string $model = PurchaseRequisitionView::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('code')->label('Document No.'),

            ExportColumn::make('doc_date')
                ->label('Document Date')
                ->formatStateUsing(fn($state) => $state ? date('d/M/Y', strtotime($state)) : '-'),

            ExportColumn::make('department_name')->label('Requested Department'),
            ExportColumn::make('requestor')->label('Requested By'),

            ExportColumn::make('priority')
                ->label('Priority')
                ->formatStateUsing(fn($state) => $state ? ucwords(strtolower(str_replace('_', ' ', $state))) : '-'),

            ExportColumn::make('doc_status')->label('Document Status'),
            ExportColumn::make('is_closed')->label('Closed Status')->formatStateUsing(fn($state) => $state ? 'Yes' : 'No'),
            ExportColumn::make('reason')->label('Reason'),

            ExportColumn::make('material_code')->label('Material Code'),
            ExportColumn::make('material_name')->label('Material Name'),
            ExportColumn::make('material_specification')->label('Specification'),

            ExportColumn::make('uom')->label('UoM'),
            ExportColumn::make('qty')->label('Qty'),
            ExportColumn::make('qty_remaining')->label('Outstanding Qty'),

            ExportColumn::make('close_by_row')
                ->label('Closed by Row')
                ->formatStateUsing(fn($state) => $state ? 'Yes' : 'No'),

            ExportColumn::make('remark')->label('Remark')
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your purchase requisition export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }

    public function getFileName(Export $export): string
    {
        return 'purchase_requisition_list_' . now()->format('YmdHis');
    }
}
