<?php

namespace App\Filament\Resources\PurchaseReceiptHeaders\Pages;

use App\Filament\Resources\PurchaseReceiptHeaders\PurchaseReceiptHeaderResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPurchaseReceiptHeader extends ViewRecord
{
    protected static string $resource = PurchaseReceiptHeaderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
