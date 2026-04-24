<?php

namespace App\Filament\Resources\PurchasePriceHeaders\Pages;

use App\Filament\Resources\PurchasePriceHeaders\PurchasePriceHeaderResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPurchasePriceHeader extends EditRecord
{
    protected static string $resource = PurchasePriceHeaderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
