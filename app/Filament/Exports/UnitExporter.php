<?php

namespace App\Filament\Exports;

use App\Models\Unit;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class UnitExporter extends Exporter
{
    protected static ?string $model = Unit::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('code')
                ->label('Unit Code'),
            ExportColumn::make('name')
                ->label('Unit Name'),
            ExportColumn::make('category')
                ->label('Unit Category')
                ->formatStateUsing(function ($state) {
                    $cleanState = trim((string) $state);

                    return match ($cleanState) {
                        'length' => 'Length',
                        'mass' => 'Mass',
                        'volume' => 'Volume',
                        'other' => 'Others',
                        default => ucfirst($cleanState),
                    };
                }),
            ExportColumn::make('baseUnit.name')
                ->label('Base Unit'),
            ExportColumn::make('conversion_factor')
                ->label('Unit Conversion Rate'),
            ExportColumn::make('is_active')
                ->label('Status')
                ->formatStateUsing(fn ($state): string => $state ? 'Active' : 'Disabled'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your unit export has completed and '.Number::format($export->successful_rows).' '.str('row')->plural($export->successful_rows).' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to export.';
        }

        return $body;
    }

    public function getFileName(Export $export): string
    {
        return 'unit_of_measurements_'.now()->format('YmdHis');
    }
}
