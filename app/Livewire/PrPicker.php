<?php

namespace App\Livewire;

use App\Models\PurchaseRequisitionDetail;
use App\Models\PurchaseRequisitionView;
use Filament\Notifications\Notification;
use Livewire\Component;
use Livewire\WithPagination;

class PrPicker extends Component
{
    use WithPagination;

    public $selected = [];
    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
        $this->reset('selected', 'selectAll');
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = $this->getQuery()->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selected = [];
        }
    }

    private function getQuery()
    {
        return PurchaseRequisitionDetail::query()
            ->with(['header', 'supplier', 'material', 'units'])
            ->where('qty_remaining', '>', 0)
            ->where('is_closed', 0)
            // ->when($this->search)
            ->orderBy('created_at', 'desc');
    }

    public function render()
    {
        $data = $this->getQuery()->paginate(10);

        return view('Filament.pr-picker', [
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

        $this->dispatch('close-modal');
        $this->dispatch('pr-items-selected', selectedIds: $this->selected);
        $this->reset('selected', 'selectAll');

        Notification::make()
            ->title('Success')
            ->body('Data selected')
            ->success()
            ->send();
    }
}
