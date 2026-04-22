<?php

namespace App\Filament\Resources\PaymentTerms\Pages;

use App\Filament\Resources\PaymentTerms\PaymentTermResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;

class ListPaymentTerms extends ListRecords
{
    protected static string $resource = PaymentTermResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->icon(Heroicon::OutlinedPlusCircle),
        ];
    }

    public function getTabs(): array
    {
        $staticTabs = ['business_date', 'order_date', 'material_receipt', 'warehouse_receipt'];

        $dynamicTabs = collect($staticTabs)->mapWithKeys(function ($item) {
            return [
                $item => Tab::make(str($item)->replace('_', ' ')->title())
                    ->modifyQueryUsing(fn (Builder $query) => $query->where('bill_period_basis', $item)),
            ];
        })->toArray();

        // Gabungkan dengan tab 'All' di urutan paling depan
        return array_merge([
            'all' => Tab::make('All Data'),
        ], $dynamicTabs);
    }
}
