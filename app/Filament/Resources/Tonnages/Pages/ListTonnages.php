<?php

namespace App\Filament\Resources\Tonnages\Pages;

use App\Filament\Resources\Tonnages\TonnageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListTonnages extends ListRecords
{
    protected static string $resource = TonnageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->icon(Heroicon::OutlinedPlusCircle)->label('New'),
        ];
    }
}
