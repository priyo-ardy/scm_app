<?php

namespace App\Filament\Exports;

use App\Models\EquipmentCategory;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class EquipmentCategoryExporter extends Exporter
{
    protected static ?string $model = EquipmentCategory::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('code'),
            ExportColumn::make('name'),
            ExportColumn::make('prefix'),
            ExportColumn::make('description')->label('Remark'),
            ExportColumn::make('is_active')->formatStateUsing(fn($state) => $state ? 'Active' : 'Deactive')->label('Status'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your equipment category export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }

    public function getFileName(Export $export): string
    {
        return 'equipment_category_' . now()->format('YmdHis');
    }
}
