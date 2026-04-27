<?php

namespace App\Filament\Resources\PurchasePriceHeaders\Pages;

use App\Filament\Resources\PurchasePriceHeaders\PurchasePriceHeaderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListPurchasePriceHeaders extends ListRecords
{
    protected static string $resource = PurchasePriceHeaderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('New')->icon(Heroicon::OutlinedPlusCircle),
        ];
    }
}
