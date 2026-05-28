<?php

namespace App\Livewire;

use App\Models\PurchaseOrderDetail;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Livewire component for selecting Purchase Order (PO) detail items.
 *
 * This component provides:
 * - Search and filtering across PO code, supplier name, and material fields.
 * - Pagination for manageable list rendering.
 * - "Select all" support for currently filtered records.
 * - Event dispatching back to parent context with selected IDs.
 * - User notifications for success and validation feedback.
 */
class PoPicker extends Component
{
    use WithPagination;

    /**
     * Selected PurchaseOrderDetail IDs (stored as string values).
     *
     * @var array<int, string>
     */
    public $selected = [];

    /**
     * Search keyword used to filter PO detail records.
     *
     * @var string
     */
    public $search = '';

    /**
     * Toggle state for selecting all currently filtered rows.
     *
     * @var bool
     */
    public $selectAll = false;

    /**
     * Handle search term updates.
     *
     * Resets pagination and clears current selections whenever
     * the search value changes, so UI state stays consistent with
     * the new filtered result set.
     *
     * @return void
     */
    public function updatedSearch()
    {
        $this->resetPage();
        $this->reset('selected', 'selectAll');
    }

    /**
     * Handle "select all" toggle updates.
     *
     * When enabled, all IDs from the current filtered query are selected.
     * When disabled, the selected list is cleared.
     *
     * @param  bool  $value
     * @return void
     */
    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = $this->getQuery()->pluck('id')->map(fn ($id) => (string) $id)->toArray();
        } else {
            $this->selected = [];
        }
    }

    /**
     * Build the base query for selectable PurchaseOrderDetail records.
     *
     * Query behavior:
     * - Eager loads related detail->supplier, material, and units relations.
     * - Includes only rows with qty_remaining > 0.
     * - Applies keyword search to:
     *   - PO code (detail.code)
     *   - supplier name (detail.supplier.name)
     *   - material code/name/specification
     * - Orders newest first by created_at.
     *
     * @return Builder
     */
    private function getQuery()
    {
        return PurchaseOrderDetail::query()
            ->with(['detail.supplier', 'material', 'units'])
            ->where('qty_remaining', '>', 0)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas(
                        'detail',
                        fn ($subQ) => $subQ->where('code', 'like', '%'.$this->search.'%')
                            ->orWhereHas('supplier', fn ($sq) => $sq->where('name', 'like', '%'.$this->search.'%'))
                    )
                        ->orWhereHas(
                            'material',
                            fn ($subQ) => $subQ->where('code', 'like', '%'.$this->search.'%')
                                ->orWhere('name', 'like', '%'.$this->search.'%')
                                ->orWhere('specification', 'like', '%'.$this->search.'%')
                        );
                });
            })
            ->orderBy('created_at', 'desc');
    }

    /**
     * Render the component view with paginated data.
     *
     * @return View
     */
    public function render()
    {
        $data = $this->getQuery()->paginate(10);

        return view('Filament.po-picker', [
            'data' => $data,
        ]);
    }

    /**
     * Dispatch selected item IDs to listening components.
     *
     * Flow:
     * - If no data is selected, show warning notification and stop.
     * - Close modal.
     * - Dispatch `po-items-selected` event with selected IDs.
     * - Reset local selection state.
     * - Show success notification.
     *
     * @return void
     */
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
        $this->dispatch('po-items-selected', selectedIds: $this->selected);
        $this->reset('selected', 'selectAll');

        Notification::make()
            ->title('Success !')
            ->body('Data selected')
            ->success()
            ->send();
    }
}
