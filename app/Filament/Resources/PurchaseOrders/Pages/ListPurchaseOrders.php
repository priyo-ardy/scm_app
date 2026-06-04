<?php

namespace App\Filament\Resources\PurchaseOrders\Pages;

use App\Filament\Resources\PurchaseOrders\PurchaseOrderResource;
use App\Models\PurchaseOrderDetail;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

class ListPurchaseOrders extends ListRecords
{
    protected static string $resource = PurchaseOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('New')->icon(Heroicon::OutlinedPlusCircle)->tooltip('New'),
        ];
    }

    protected function getTableQuery(): Builder|Relation|null
    {
        return PurchaseOrderDetail::with([
            'header',
            'material',
            'units'
        ]);
    }
}
