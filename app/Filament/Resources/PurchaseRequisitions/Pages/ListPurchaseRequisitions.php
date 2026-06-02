<?php

namespace App\Filament\Resources\PurchaseRequisitions\Pages;

use App\Filament\Resources\PurchaseRequisitions\PurchaseRequisitionResource;
use App\Models\PurchaseRequisitionDetail;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

class ListPurchaseRequisitions extends ListRecords
{
    protected static string $resource = PurchaseRequisitionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('New')->icon(Heroicon::OutlinedPlusCircle)->tooltip('Create new purchase requisition'),
        ];
    }

    protected function getTableQuery(): Builder|Relation|null
    {
        return PurchaseRequisitionDetail::with([
            'header',
            'units',
            'material',
            'supplier'
        ]);
    }
}
