<?php

namespace App\Filament\Exports;

use App\Models\PaymentMethod;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class PaymentMethodExporter extends Exporter
{
    protected static ?string $model = PaymentMethod::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('code')
                ->label('Code'),

            ExportColumn::make('name')
                ->label('Name'),

            // Tambahin default '-' kalau kategorinya kosong biar gak failed
            ExportColumn::make('categoryList.name')
                ->label('Settlement Category')
                ->default('-'),

            ExportColumn::make('type')
                ->label('Business Type')
                ->formatStateUsing(fn($state) => $state ? ucwords(str_replace('_', ' ', $state)) : '-'),

            ExportColumn::make('commission_fee')
                ->label('Commission Fee')
                // Pakai casting (bool) biar record 0/1 atau true/false kebaca bener
                ->formatStateUsing(fn($state) => (bool)$state ? 'Yes' : 'No'),

            ExportColumn::make('payment_mode')
                ->label('Mode of Payment')
                ->formatStateUsing(fn($state) => $state ? ucwords(str_replace('_', ' ', $state)) : '-'),

            ExportColumn::make('is_active')
                ->label('Status')
                ->formatStateUsing(fn($state) => (bool)$state ? 'Enable' : 'Disable'),

            ExportColumn::make('description')
                ->label('Remarks')
                ->default('-'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your payment method export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }

    public function getFileName(Export $export): string
    {
        return "payment_method_list_" . date("YmdHis");
    }
}
