<?php

namespace App\Filament\Exports;

use App\Models\Customer;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class CustomerExporter extends Exporter
{
    protected static ?string $model = Customer::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name'),
            ExportColumn::make('address'),
            ExportColumn::make('email'),
            ExportColumn::make('phone'),
            ExportColumn::make('fax'),
            ExportColumn::make('website'),
            ExportColumn::make('contact_person'),
            ExportColumn::make('contact_person_email'),
            ExportColumn::make('contact_person_phone'),
            ExportColumn::make('registration_no'),
            ExportColumn::make('tax_no'),
            ExportColumn::make('vat'),
            ExportColumn::make('bank_name'),
            ExportColumn::make('bank_account_no'),
            ExportColumn::make('bank_account_name'),
            ExportColumn::make('avatar'),
            ExportColumn::make('payment_method')->formatStateUsing(fn(string $state): string => match ($state) {
                'cash' => 'Cash',
                'bank' => 'Bank Transfer',
                'cheque' => 'Cheque',
                'term_30' => '30 Days after delivery',
                'term_60' => '60 Days after delivery',
                'term_90' => '90 Days after delivery',
                default => $state
            }),
            ExportColumn::make('remark'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your customer export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }

    public function getFileName(Export $export): string
    {
        return 'customer-' . now()->format('YmdHis');
    }
}
