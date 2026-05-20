<?php

namespace App\Livewire;

use App\Models\PurchaseOrderDetail;
use Filament\Notifications\Notification;
use Livewire\Component;
use Livewire\WithPagination;

class PoPicker extends Component
{
    use WithPagination;

    // Property untuk checkbox selection
    public $selected = [];

    // Property untuk search
    public $search = '';

    // Property untuk select all
    public $selectAll = false;

    // Reset page saat search berubah
    public function updatedSearch()
    {
        $this->resetPage();
        $this->reset('selected', 'selectAll');
    }

    // Update select all
    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = $this->getQuery()->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selected = [];
        }
    }

    // Get query builder untuk search
    private function getQuery()
    {
        return PurchaseOrderDetail::query()
            // OPTIMASI: Eager load 'detail.supplier' & 'units' untuk mencegah N+1 query pada Blade
            ->with(['detail.supplier', 'material', 'units'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {

                    // 1. Search by PO Code ATAU Supplier Name (Keduanya ada di PurchaseOrderHeader)
                    $q->whereHas(
                        'detail',
                        fn($subQ) =>
                        $subQ->where('code', 'like', '%' . $this->search . '%')
                            ->orWhereHas('supplier', fn($sq) => $sq->where('name', 'like', '%' . $this->search . '%'))
                    )

                        // 2. OPTIMASI: Gabungkan pencarian material (code, name, spec) ke dalam 1 subquery
                        ->orWhereHas(
                            'material',
                            fn($subQ) =>
                            $subQ->where('code', 'like', '%' . $this->search . '%')
                                ->orWhere('name', 'like', '%' . $this->search . '%')
                                ->orWhere('specification', 'like', '%' . $this->search . '%')
                        );
                });
            })
            ->orderBy('created_at', 'desc');
    }

    public function render()
    {
        $data = $this->getQuery()->paginate(10);

        return view('Filament.po-picker', [
            'data' => $data
        ]);
    }

    public function dispatchSelected()
    {
        if (empty($this->selected)) {
            Notification::make()
                ->title('Warning !')
                ->body('No data selected')
                ->warning()
                ->send();

            return;
        }

        $this->dispatch('po-items-selected', selectedIds: $this->selected);

        $this->reset('selected', 'selectAll');

        Notification::make()
            ->title('Success !')
            ->body('Data selected')
            ->success()
            ->send();
    }
}
