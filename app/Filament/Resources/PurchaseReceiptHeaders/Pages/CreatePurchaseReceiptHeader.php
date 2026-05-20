<?php

namespace App\Filament\Resources\PurchaseReceiptHeaders\Pages;

use App\Filament\Resources\PurchaseReceiptHeaders\PurchaseReceiptHeaderResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Icons\Heroicon;
use App\Livewire\PoPicker;
use App\Models\PurchaseOrderDetail;
use Filament\Schemas\Components\Livewire as ComponentsLivewire;
use Livewire\Attributes\On; // 1. WAJIB IMPORT INI
use Illuminate\Support\Str; // 2. WAJIB IMPORT INI UNTUK GENERATE UUID REPEATER

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
                ->schema([
                    ComponentsLivewire::make(PoPicker::class),
                ])
                ->modalSubmitAction(false)
                ->modalCancelAction(false)
                ->modalWidth('6xl')
        ];
    }

    #[On('po-items-selected')]
    public function handleSelectedPoItems(array $selectedIds)
    {
        // Ambil detail PO beserta relasi headernya
        $poDetails = PurchaseOrderDetail::with(['detail', 'material', 'units'])->find($selectedIds);

        if ($poDetails->isEmpty()) {
            return;
        }

        // 4. SET DATA HEADER (SUPPLIER)
        $firstItem = $poDetails->first();
        if ($firstItem && $firstItem->detail) {
            $this->data['supplier_id'] = $firstItem->detail->supplier_id;
        }

        // 5. SET DATA BANYAK ITEM KE REPEATER (KEY: 'details')
        $currentItems = $this->data['details'] ?? [];

        foreach ($poDetails as $detail) {
            // Cek duplikasi agar item yang sama tidak masuk dua kali jika di-klik ulang
            $isDuplicate = collect($currentItems)->contains('po_detail_id', $detail->id);

            if ($isDuplicate) {
                continue;
            }

            // Wajib generate UUID sebagai index baris agar sinkron dengan AlpineJS di Frontend
            $rowId = (string) Str::uuid();

            // Petakan data sesuai dengan struktur komponen input di PurchaseReceiptHeaderForm.php
            $currentItems[$rowId] = [
                'po_detail_id'  => $detail->id,
                'material_id'   => $detail->material_id,
                'material_name' => $detail->material?->name,
                'specification' => $detail->material?->specification,
                'unit_id'       => $detail->unit_id ?? $detail->material?->purchase_unit_id,
                'qty_received'  => $detail->qty_remaining, // Set sisa PO sebagai default kuantitas terima
                'lot_number'    => '', // Kosongkan agar user bisa isi manual (karena required)
                'remark'        => '',
            ];
        }

        // Masukkan array items yang sudah matang kembali ke form state
        $this->data['details'] = $currentItems;

        // 6. RE-REFRESH/FILL FORM STATE AGAR MUNCUL DI LAYAR
        $this->form->fill($this->data);

        // 7. AKTIFKAN KEMBALI UNTUK MENUTUP MODAL SECARA OTOMATIS
        $this->dispatch('close-modal', id: 'page-action-source');
    }

    // public function closeSelectPoModal()
    // {
    //     $this->unmountMountedAction();
    // }
}
