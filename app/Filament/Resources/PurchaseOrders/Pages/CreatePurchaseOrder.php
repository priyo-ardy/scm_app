<?php

namespace App\Filament\Resources\PurchaseOrders\Pages;

use App\Filament\Resources\PurchaseOrders\PurchaseOrderResource;
use App\Livewire\PrPicker;
use App\Models\PurchaseRequisitionDetail;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Livewire;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;
use Livewire\Attributes\On;

class CreatePurchaseOrder extends CreateRecord
{
    protected static string $resource = PurchaseOrderResource::class;


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
                ->tooltip('Choose purchase requisition document')
                ->color('primary')
                ->icon(Heroicon::OutlinedCog8Tooth)
                ->button()
                ->schema([
                    Livewire::make(PrPicker::class)
                ])
                ->modalSubmitAction(false)
                ->modalCancelAction(false)
                ->modalWidth('7xl')
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['doc_status'] = 'approved';

        $totalAmount = 0;
        $totalTax = 0;

        if (isset($data['details'])) {
            foreach ($data['details'] as $detail) {
                $amount = (float) str_replace(',', '', $detail['total_amount'] ?? 0);
                $tax = (float) str_replace(',', '', $detail['tax_amount'] ?? 0);

                $totalAmount += $amount;
                $totalTax += $tax;
            }
        }

        $data['total_amount'] = $totalAmount;
        $data['tax_amount'] = $totalTax;

        return $data;
    }

    #[On('pr-items-selected')]
    public function handleSelectedPrItems(array $selectedIds)
    {
        $prDetails = PurchaseRequisitionDetail::with(['header', 'material', 'unit', 'supplier'])->find($selectedIds);

        if ($prDetails->isEmpty()) {
            return;
        }

        $currentItems = $this->data ?? [];

        foreach ($prDetails as $detail) {
            $isDuplicate = collect($currentItems)->contains('pr_derail_id', $detail->id);

            if ($isDuplicate) {
                continue;
            }

            $rowId = (string) Str::uuid();

            $currentItems[$rowId] = [
                'pr_detail_id' => $detail->id,
                'material_id' => $detail->material_id,
                'material_name' => $detail->material?->name,
                'specification' => $detail->material?->specification,
                'unit_id' => $detail->unit_id ?? $detail->material?->purchase_unit_id,
                'qty_request' => $detail->qty,
                'qty_outstanding' => $detail->qty_remaining,
                'remark' => $detail->remark
            ];
        }

        $this->data['details'] = $currentItems;
        $this->form->fill($this->data);
        $this->dispatch('close-modal');
        $this->mountedActions = [];
    }
}
