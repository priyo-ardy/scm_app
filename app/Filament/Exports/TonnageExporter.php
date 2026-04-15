<?php

namespace App\Filament\Exports;

use App\Models\Tonnage;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class TonnageExporter extends Exporter
{
    protected static ?string $model = Tonnage::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('code')->label('Tonnage Code'),
            ExportColumn::make('name')->label('Tonnage Name'),
            ExportColumn::make('clamping_force_kn')->label('Clamping Force KN')->suffix(' kN'),
            ExportColumn::make('std_dbugging')->label('Standart Debugging')->suffix(' Kg'),
            ExportColumn::make('remark')->label('Remark'),
            ExportColumn::make('is_active')->formatStateUsing(fn ($state) => $state ? 'Active' : 'Deactive'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your tonnage export has completed and '.Number::format($export->successful_rows).' '.str('row')->plural($export->successful_rows).' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to export.';
        }

        return $body;
    }

    public function getFileName(Export $export): string
    {
        return 'tonnage_'.now()->format('YmdHis');
    }
}
