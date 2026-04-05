<?php

namespace App\Filament\Resources\TimeZones\Pages;

use App\Filament\Resources\TimeZones\TimeZoneResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditTimeZone extends EditRecord
{
    protected static string $resource = TimeZoneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
