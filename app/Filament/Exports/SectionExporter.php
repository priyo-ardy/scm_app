<?php

namespace App\Filament\Exports;

use App\Models\Section;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Number;

class SectionExporter extends Exporter
{
    protected static ?string $model = Section::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('companyList.name')->label('Company'),
            ExportColumn::make('code')->label('Section Code'),
            ExportColumn::make('name')->label('Section Name'),
            ExportColumn::make('sectionHead.name')->label('Section Head'),
            ExportColumn::make('dept.name')->label('Department'),
            ExportColumn::make('is_active')->formatStateUsing(fn($state) => $state ? 'Enable' : 'Disable')->label('Status'),
            ExportColumn::make('description'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your section export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }

    public function getFileName(Export $export): string
    {
        return "section_list_" . date("YmdHis");
    }

    public static function modifyQuery(Builder $query): Builder
    {
        return $query->withoutGlobalScopes();
    }
}
