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
            ExportColumn::make('companyList.name')->label('Company'),
            ExportColumn::make('category')->label('Category')->formatStateUsing(fn(string $state): string => ($state == 'local') ? 'Domestic' : 'Overseas'),
            ExportColumn::make('code')->label('Customer Code'),
            ExportColumn::make('name')->label('Customer Name'),
            ExportColumn::make('short_name')->label('Short Name'),
            ExportColumn::make('address')->label('Address'),
            ExportColumn::make('email')->label('Email Address'),
            ExportColumn::make('phone')->label('Phone No.'),
            ExportColumn::make('fax')->label('Fax No.'),
            ExportColumn::make('website')->label('Website'),
            ExportColumn::make('contact_person')->label('Contact Person'),
            ExportColumn::make('contact_person_email')->label('Contact Person Email'),
            ExportColumn::make('contact_person_phone')->label('Contact Person Phone No.'),
            ExportColumn::make('registration_no')->label('Company Registration No.'),
            ExportColumn::make('tax_no')->label('Tax Registration No.'),
            ExportColumn::make('vat')->label('VAT'),
            ExportColumn::make('bank_name')->label('Bank Name'),
            ExportColumn::make('bank_account_no')->label('Bank Account No.'),
            ExportColumn::make('bank_account_name')->label('Bank Acoount Name'),
            ExportColumn::make('is_active')->label('Status')->formatStateUsing(fn(string $state): string => $state ? 'Enable' : 'Disable'),
            ExportColumn::make('paymentList.name')->label('Payment Terms'),
            ExportColumn::make('currencyList.code')->label('Default Currency'),
            ExportColumn::make('paymentMethodList.name')->label('Payment Method'),
            ExportColumn::make('remark')->label('Remark'),
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
        return 'customer_list_' . now()->format('YmdHis');
    }
}
