<?php

namespace App\Filament\Resources\SetllementCategories\Pages;

use App\Filament\Resources\SetllementCategories\SetllementCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;

class ListSetllementCategories extends ListRecords
{
    protected static string $resource = SetllementCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->icon(Heroicon::OutlinedPlusCircle)->label('New'),
        ];
    }
}
