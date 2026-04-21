<?php

namespace App\Filament\Exports;

use App\Models\MaterialCategory;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class MaterialCategoryExporter extends Exporter
{
    protected static ?string $model = MaterialCategory::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('companyList.name')->label('Company'),
            ExportColumn::make('header.name')->label('Parent Group')->default('-'),
            ExportColumn::make('code')->label('Code'),
            ExportColumn::make('name')->label('Name'),
            ExportColumn::make('is_active')->label('Status')->formatStateUsing(fn($state) => $state ? 'Enable' : 'Disable'),
            ExportColumn::make('remark')->label('Remark'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your material category export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }

    public function getFileName(Export $export): string
    {
        return 'material_category_' . now()->format('YmdHis');
    }
}
