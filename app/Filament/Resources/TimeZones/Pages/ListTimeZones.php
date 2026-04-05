<?php

namespace App\Filament\Resources\TimeZones\Pages;

use App\Filament\Resources\TimeZones\TimeZoneResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTimeZones extends ListRecords
{
    protected static string $resource = TimeZoneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
