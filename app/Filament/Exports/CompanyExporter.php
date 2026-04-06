<?php

namespace App\Filament\Exports;

use App\Models\Company;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class CompanyExporter extends Exporter
{
    protected static ?string $model = Company::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('code'),
            ExportColumn::make('name'),
            ExportColumn::make('legal_name'),
            ExportColumn::make('slug'),
            ExportColumn::make('email'),
            ExportColumn::make('phone'),
            ExportColumn::make('fax'),
            ExportColumn::make('website'),
            ExportColumn::make('address'),
            ExportColumn::make('postal_code'),
            ExportColumn::make('tax_id'),
            ExportColumn::make('tax_address'),
            ExportColumn::make('is_pkp'),
            ExportColumn::make('bank_name'),
            ExportColumn::make('bank_account'),
            ExportColumn::make('bank_beneficiary'),
            ExportColumn::make('logo'),
            ExportColumn::make('favicon'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
            ExportColumn::make('deleted_at'),
            ExportColumn::make('currency.name'),
            ExportColumn::make('timezone.name'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your company export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
