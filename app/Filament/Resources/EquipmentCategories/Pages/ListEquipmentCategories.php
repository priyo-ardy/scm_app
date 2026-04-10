<?php

namespace App\Filament\Resources\EquipmentCategories\Pages;

use App\Filament\Resources\EquipmentCategories\EquipmentCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListEquipmentCategories extends ListRecords
{
    protected static string $resource = EquipmentCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->icon(Heroicon::OutlinedPlusCircle),
        ];
    }
}
