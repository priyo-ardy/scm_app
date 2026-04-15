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
            ExportColumn::make('companyList.name'),
            ExportColumn::make('categoryList.name'),
            ExportColumn::make('code'),
            ExportColumn::make('name'),
            ExportColumn::make('specification'),
            ExportColumn::make('unitList.code'),
            ExportColumn::make('purchaseUnitList.code'),
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
            ExportColumn::make('workshopList.name'),
            ExportColumn::make('cust_part_no'),
            ExportColumn::make('cust_part_name'),
            ExportColumn::make('delivery_location'),
            ExportColumn::make('enable_min_stock')->formatStateUsing(fn (bool $state): string => $state ? 'True' : 'False'),
            ExportColumn::make('min_stock'),
            ExportColumn::make('enable_safety_stock')->formatStateUsing(fn (bool $state): string => $state ? 'True' : 'False'),
            ExportColumn::make('safety_stock'),
            ExportColumn::make('enable_max_stock')->formatStateUsing(fn (bool $state): string => $state ? 'True' : 'False'),
            ExportColumn::make('max_stock'),
            ExportColumn::make('reorder_point'),
            ExportColumn::make('description'),
            ExportColumn::make('mold_no'),
            ExportColumn::make('supplierList.name'),
            ExportColumn::make('is_hazardous')->formatStateUsing(fn (bool $state): string => $state ? 'True' : 'False'),
            ExportColumn::make('storage_location_id'),
            ExportColumn::make('enable_expired')->formatStateUsing(fn (bool $state): string => $state ? 'True' : 'False'),
            ExportColumn::make('expiry_days'),
            ExportColumn::make('lead_time_days'),
            ExportColumn::make('status'),
            ExportColumn::make('drawing_no'),
            ExportColumn::make('process_routes'),
            ExportColumn::make('drawing_level'),
            ExportColumn::make('revision_no'),
            ExportColumn::make('tonnageList.code'),
            ExportColumn::make('hs_code'),
            ExportColumn::make('regrind_method'),
            ExportColumn::make('carton_category'),
            ExportColumn::make('carton_length'),
            ExportColumn::make('carton_width'),
            ExportColumn::make('carton_height'),
            ExportColumn::make('dimension_unit_id'),
            ExportColumn::make('stacking_limit'),
            ExportColumn::make('is_inspection_required')->formatStateUsing(fn (bool $state): string => $state ? 'True' : 'False'),
            ExportColumn::make('last_purchase_price'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your material export has completed and '.Number::format($export->successful_rows).' '.str('row')->plural($export->successful_rows).' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to export.';
        }

        return $body;
    }
}
