<?php

namespace App\Filament\Resources\PurchaseOrders\Pages;

use App\Filament\Resources\PurchaseOrders\PurchaseOrderResource;
use App\Livewire\PrPicker;
use App\Models\PurchaseRequisitionDetail;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Form;
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
                ->visible(function ($livewire) {
                    return !empty($livewire->data['supplier_id']);
                })
                ->schema([
                    Livewire::make(PrPicker::class, function ($livewire) {
                        return [
                            'supplier_id' => $livewire->data['supplier_id'] ?? null,
                        ];
                    })
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
        $prDetails = PurchaseRequisitionDetail::with(['header', 'material', 'units', 'supplier'])->find($selectedIds);

        if ($prDetails->isEmpty()) {
            return;
        }

        $firstItem = $prDetails->first();
        if ($firstItem && $firstItem->header) {
            $this->data['department_id'] = $firstItem->header->department_id;
        }

        $currentItems = $this->data['details'] ?? [];

        foreach ($prDetails as $detail) {
            $isDuplicate = collect($currentItems)->contains('pr_detail_id', $detail->id);

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
                'qty' => $detail->qty_remaining,
                'arrival_date' => $detail->arrival_date,
                'remark' => $detail->remark
            ];
        }

        // 3. Masukkan kembali array yang sudah diperbarui ke dalam state form
        $this->data['details'] = $currentItems;

        // 4. Re-hydrate form agar Filament merender ulang Repeater di UI
        $this->form->fill($this->data);

        // 5. Tutup modal picker
        $this->dispatch('close-modal');
        $this->mountedActions = [];
    }
}
