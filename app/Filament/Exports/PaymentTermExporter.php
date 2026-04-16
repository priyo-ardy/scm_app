<?php

namespace App\Filament\Exports;

use App\Models\PaymentTerm;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class PaymentTermExporter extends Exporter
{
    protected static ?string $model = PaymentTerm::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('code')->label('Code'),
            ExportColumn::make('bill_period_basis')
                ->label('Bill Period Basis')
                ->formatStateUsing(fn(string $state): string => ucwords(str_replace('_', ' ', $state))),
            ExportColumn::make('name')->label('Name'),
            ExportColumn::make('is_active')->label('Status')->formatStateUsing(fn($state) => $state ? 'Active' : 'Not Active'),
            ExportColumn::make('description')->label('Description'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your payment term export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }

    public function getFileName(Export $export): string
    {
        return 'payment_terms_list_' . date("YmdHis");
    }
}
