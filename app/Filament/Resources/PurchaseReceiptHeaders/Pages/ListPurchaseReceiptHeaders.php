<?php

namespace App\Filament\Resources\PurchaseReceiptHeaders\Pages;

use App\Filament\Resources\PurchaseReceiptHeaders\PurchaseReceiptHeaderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListPurchaseReceiptHeaders extends ListRecords
{
    protected static string $resource = PurchaseReceiptHeaderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('New')
                ->tooltip('New')
                ->icon(Heroicon::OutlinedPlusCircle),
        ];
    }
}
