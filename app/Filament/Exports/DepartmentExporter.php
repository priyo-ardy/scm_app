<?php

namespace App\Filament\Exports;

use App\Models\Department;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class DepartmentExporter extends Exporter
{
    protected static ?string $model = Department::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('CompanyList.name')->label('Company'),
            ExportColumn::make('code')->label('Code'),
            ExportColumn::make('name')->label('Name'),
            ExportColumn::make('managerList.name')->label('Department Manager'),
            ExportColumn::make('is_active')->label('Status')->formatStateUsing(fn($state) => $state ? 'Enable' : 'Disable'),
            ExportColumn::make('cost_center_code')->label('Cost Center Code'),
            ExportColumn::make('remark')->label('Remark'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your department export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }

    public function getFileName(Export $export): string
    {
        return 'department_list_' . date("YmdHis");
    }
}
