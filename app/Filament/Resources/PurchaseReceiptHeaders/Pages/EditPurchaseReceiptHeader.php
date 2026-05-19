<?php

namespace App\Filament\Resources\PurchaseReceiptHeaders\Pages;

use App\Filament\Resources\PurchaseReceiptHeaders\PurchaseReceiptHeaderResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPurchaseReceiptHeader extends EditRecord
{
    protected static string $resource = PurchaseReceiptHeaderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
