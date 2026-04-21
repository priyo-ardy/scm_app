<?php

namespace App\Filament\Exports;

use App\Models\Workshop;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class WorkshopExporter extends Exporter
{
    protected static ?string $model = Workshop::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('company.name')->label('Company'),
            ExportColumn::make('branch.name')->label('Branch'),
            ExportColumn::make('code')->label('Workshop Code'),
            ExportColumn::make('name')->label('Workshop Name'),
            ExportColumn::make('location_detail')->label('Location Details'),
            ExportColumn::make('user.name')->label('Workshop PIC'),
            ExportColumn::make('phone')->label('Workhsop Ext. No.'),
            ExportColumn::make('is_active')->formatStateUsing(fn($state) => $state ? 'Enable' : 'Disable'),
            ExportColumn::make('remarks')->label('Remark'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your workshop export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }

    public function getFileName(Export $export): string
    {
        return 'workshop_' . now()->format('YmdHis');
    }
}
