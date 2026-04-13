<?php

namespace App\Filament\Exports;

use App\Models\Equipment;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class EquipmentExporter extends Exporter
{
    protected static ?string $model = Equipment::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('companyList.name')->label('Company'),
            ExportColumn::make('branchList.name')->label('Branch'),
            ExportColumn::make('category.name')->label('Equipment Category'),
            ExportColumn::make('equipment_no')->label('Equipment No'),
            ExportColumn::make('code')->label('Equipment Code'),
            ExportColumn::make('name')->label('Equipment Name'),
            ExportColumn::make('specification')->label('Specification'),
            ExportColumn::make('tonnageList.name')->label('Tonnage'),
            ExportColumn::make('brand')->label('Brand'),
            ExportColumn::make('model_number')->label('Model Number'),
            ExportColumn::make('serial_number')->label('Serial Number'),
            ExportColumn::make('purchase_date')
                ->label('Purchase Date')
                ->formatStateUsing(function (?string $state) {
                    if (blank($state) || str_starts_with($state, '0000')) {
                        return null;
                    }

                    return Carbon::parse($state)->format('d-M-Y');
                }),
            ExportColumn::make('machine_rate')->label('Machine/Equipment Rate'),
            ExportColumn::make('status')->formatStateUsing(fn(string $state): string => match ($state) {
                'standby' => 'Standby',
                'running' => 'Running',
                'breakdown' => 'Breakdown',
                'repair' => "Repair",
                'default' => 'Running'
            }),
            ExportColumn::make('installation_date')
                ->label('Installation Date')
                ->formatStateUsing(function (?string $state) {
                    if (blank($state) || str_starts_with($state, '0000')) {
                        return null;
                    }

                    return Carbon::parse($state)->format('d-M-Y');
                }),
            ExportColumn::make('last_maintenance')
                ->label('Last Maintenance Date')
                ->formatStateUsing(function (?string $state) {
                    if (blank($state) || str_starts_with($state, '0000')) {
                        return null;
                    }

                    return Carbon::parse($state)->format('d-M-Y');
                }),
            ExportColumn::make('total_shots')->label('Total Shots'),
            ExportColumn::make('workshopList.name')->label('Workshop'),
            ExportColumn::make('description')->label('Description')
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your equipment export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }

    public function getFileName(Export $export): string
    {
        return 'equipment_list_' . now()->format('YmdHis');
    }
}
