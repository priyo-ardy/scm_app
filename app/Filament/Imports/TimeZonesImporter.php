<?php

namespace App\Filament\Imports;

use App\Models\TimeZone;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class TimeZonesImporter extends Importer
{
    protected static ?string $model = TimeZone::class;

    public static function getColumns(): array
    {
        return [
            //
        ];
    }

    public function resolveRecord(): TimeZone
    {
        return TimeZone::firstOrNew([
            'name' => $this->data['name'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your time zones import has completed and '.Number::format($import->successful_rows).' '.str('row')->plural($import->successful_rows).' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to import.';
        }

        return $body;
    }
}
