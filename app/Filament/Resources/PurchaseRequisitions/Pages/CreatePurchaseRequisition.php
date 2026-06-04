<?php

namespace App\Filament\Resources\PurchaseRequisitions\Pages;

use App\Filament\Resources\PurchaseRequisitions\PurchaseRequisitionResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class CreatePurchaseRequisition extends CreateRecord
{
    protected static string $resource = PurchaseRequisitionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Backt to list')
                ->icon(Heroicon::OutlinedArrowLeftCircle)
                ->color('gray')
                ->tooltip('Back to list')
                ->url(static::getResource()::getUrl('index')),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['requester_id'] = Auth::id();
        $data['qty_remaining'] = $data['qty'] ?? 0;


        return $data;
    }
}
