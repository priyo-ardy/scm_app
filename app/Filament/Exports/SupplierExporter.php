<?php

namespace App\Filament\Exports;

use App\Models\Supplier;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class SupplierExporter extends Exporter
{
    protected static ?string $model = Supplier::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('code')->label('Supplier Code'),
            ExportColumn::make('name')->label('Supplier Name'),
            ExportColumn::make('address')->label('Supplier Address'),
            ExportColumn::make('email')->label('Email Address'),
            ExportColumn::make('phone')->label('Phone Number'),
            ExportColumn::make('fax')->label('Fax Number'),
            ExportColumn::make('website')->label('Website'),
            ExportColumn::make('contact_person')->label('Contact Person Name'),
            ExportColumn::make('contact_person_email')->label('Contact Person Email'),
            ExportColumn::make('contact_person_phone')->label('Contact Person Phone'),
            ExportColumn::make('registration_no')->label('Company Registration No.'),
            ExportColumn::make('tax_no')->label('Tax Registration No'),
            ExportColumn::make('vat')->label('VAT (%)'),
            ExportColumn::make('bank_name')->label('Bank Name'),
            ExportColumn::make('bank_account_no')->label('Bank Account No'),
            ExportColumn::make('bank_account_name')->label('Bank Account Name'),
            ExportColumn::make('payment_method')->formatStateUsing(fn(string $state): string => match ($state) {
                'cash' => 'Cash',
                'bank' => 'Bank Transfer',
                'cheque' => 'Cheque',
                '30' => '30 Days after delivery',
                '60' => '60 Days after delivery',
                '90' => '90 Days after delivery',
            }),
            ExportColumn::make('remark')->label('Remark')
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your supplier export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }

    public function getFileName(Export $export): string
    {
        return 'supplier-' . now()->format('YmdHis');
    }
}
