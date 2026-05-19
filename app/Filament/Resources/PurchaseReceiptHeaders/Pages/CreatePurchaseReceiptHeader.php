<?php

namespace App\Filament\Resources\PurchaseReceiptHeaders\Pages;

use App\Filament\Resources\PurchaseReceiptHeaders\PurchaseReceiptHeaderResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class CreatePurchaseReceiptHeader extends CreateRecord
{
    protected static string $resource = PurchaseReceiptHeaderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Back to List')
                ->icon(Heroicon::OutlinedArrowLeft)
                ->tooltip('Back to List')
                ->url(static::getResource()::getUrl('index'))
                ->color('gray'),
            Action::make('source')
                ->label('Select Document')
                ->tooltip('Select source document')
                ->color('primary')
                ->icon(Heroicon::OutlinedCog8Tooth)
                ->button()
                ->modalHeading('Select Source Document')
                ->modalContent()
                ->modalSubmitActionLabel('Select Document')
                ->modalSubmitAction(function () {})
                ->modalWidth('6xl')
        ];
    }
}
