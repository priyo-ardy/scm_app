<?php

namespace App\Filament\Resources\PurchaseReceiptHeaders\Pages;

use App\Filament\Resources\PurchaseReceiptHeaders\PurchaseReceiptHeaderResource;
use App\Livewire\PoPicker;
use App\Models\PurchaseOrderDetail;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Livewire as ComponentsLivewire;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;
use Livewire\Attributes\On;

/**
 * Filament page for creating a Purchase Receipt Header record.
 *
 * Responsibilities:
 * - Provides header actions for navigation and source-document selection.
 * - Opens a PO picker modal (Livewire component) to select PO detail rows.
 * - Listens for selected PO item IDs and maps them into receipt detail form rows.
 * - Prevents duplicate PO detail insertion into current form state.
 */
class CreatePurchaseReceiptHeader extends CreateRecord
{
    /**
     * Resource class bound to this Create page.
     *
     * @var class-string<\Filament\Resources\Resource>
     */
    protected static string $resource = PurchaseReceiptHeaderResource::class;

    /**
     * Define actions displayed in the page header.
     *
     * Actions:
     * - back: Navigate to the resource index page.
     * - source: Open modal to select source document lines via PoPicker.
     *
     * @return array<int, Action>
     */
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
                ->schema([
                    ComponentsLivewire::make(PoPicker::class),
                ])
                ->modalSubmitAction(false)
                ->modalCancelAction(false)
                ->modalWidth('6xl'),
        ];
    }

    /**
     * Handle selected Purchase Order detail IDs from the PoPicker component.
     *
     * Event: `po-items-selected`
     *
     * Processing flow:
     * - Load selected PO details with required relations.
     * - Set supplier_id from the first selected PO header detail.
     * - Merge selected items into existing `details` form state.
     * - Skip rows already present (duplicate `po_detail_id`).
     * - Generate UUID keys for new repeater/form-detail rows.
     * - Fill form state and close modal action.
     *
     * @param  array<int, string|int>  $selectedIds
     * @return void
     */
    #[On('po-items-selected')]
    public function handleSelectedPoItems(array $selectedIds)
    {
        $poDetails = PurchaseOrderDetail::with(['detail', 'material', 'units'])->find($selectedIds);

        if ($poDetails->isEmpty()) {
            return;
        }

        $firstItem = $poDetails->first();
        if ($firstItem && $firstItem->detail) {
            $this->data['supplier_id'] = $firstItem->detail->supplier_id;
            $this->data['currency_id'] = $firstItem->detail->currency_id;
            $this->data['currency_id'] = $firstItem->detail->exchange_rate;
        }

        $currentItems = $this->data['details'] ?? [];

        foreach ($poDetails as $detail) {
            $isDuplicate = collect($currentItems)->contains('po_detail_id', $detail->id);

            if ($isDuplicate) {
                continue;
            }

            $rowId = (string) Str::uuid();

            $currentItems[$rowId] = [
                'po_id' => $detail->po_id,
                'po_detail_id' => $detail->id,
                'material_id' => $detail->material_id,
                'material_name' => $detail->material?->name,
                'specification' => $detail->material?->specification,
                'unit_id' => $detail->unit_id ?? $detail->material?->purchase_unit_id,
                'qty_received' => $detail->qty_remaining,
                'lot_number' => '',
                'remark' => '',
            ];
        }

        $this->data['details'] = $currentItems;

        $this->form->fill($this->data);

        $this->dispatch('close-modal');
        $this->mountedActions = [];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['doc_status'] = 'approved';

        return $data;
    }
}
