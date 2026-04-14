<?php

namespace App\Filament\Exports;

use App\Models\Material;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class MaterialExporter extends Exporter
{
    protected static ?string $model = Material::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('company_id'),
            ExportColumn::make('category_id'),
            ExportColumn::make('code'),
            ExportColumn::make('name'),
            ExportColumn::make('specification'),
            ExportColumn::make('unit_id'),
            ExportColumn::make('purchase_unit_id'),
            ExportColumn::make('unit_conversion_rate'),
            ExportColumn::make('spq'),
            ExportColumn::make('qty_bag'),
            ExportColumn::make('net_weight'),
            ExportColumn::make('gross_weight'),
            ExportColumn::make('sprue'),
            ExportColumn::make('cycle_time'),
            ExportColumn::make('shift_capacity'),
            ExportColumn::make('properties'),
            ExportColumn::make('color'),
            ExportColumn::make('cavity'),
            ExportColumn::make('workshop_id'),
            ExportColumn::make('cust_part_no'),
            ExportColumn::make('cust_part_name'),
            ExportColumn::make('avatar'),
            ExportColumn::make('enable_min_stock'),
            ExportColumn::make('min_stock'),
            ExportColumn::make('enable_safety_stock'),
            ExportColumn::make('safety_stock'),
            ExportColumn::make('enabl_max_stock'),
            ExportColumn::make('max_stock'),
            ExportColumn::make('reorder_point'),
            ExportColumn::make('description'),
            ExportColumn::make('supplier_id'),
            ExportColumn::make('is_hazardous'),
            ExportColumn::make('storage_location_id'),
            ExportColumn::make('enable_expired'),
            ExportColumn::make('expiry_days'),
            ExportColumn::make('lead_time_days'),
            ExportColumn::make('status'),
            ExportColumn::make('revision_no'),
            ExportColumn::make('hs_code'),
            ExportColumn::make('regrind_method'),
            ExportColumn::make('carton_length'),
            ExportColumn::make('carton_width'),
            ExportColumn::make('carton_height'),
            ExportColumn::make('dimension_unit_id'),
            ExportColumn::make('stacking_limit'),
            ExportColumn::make('is_inspection_required'),
            ExportColumn::make('last_purchase_price'),
            ExportColumn::make('images'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
            ExportColumn::make('deleted_at'),
            ExportColumn::make('created_by'),
            ExportColumn::make('updated_by'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your material export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
