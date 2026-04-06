<?php

namespace App\Filament\Resources\TimeZones\Pages;

use App\Filament\Resources\TimeZones\TimeZoneResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListTimeZones extends ListRecords
{
    protected static string $resource = TimeZoneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->icon(Heroicon::PlusCircle),
        ];
    }
}
