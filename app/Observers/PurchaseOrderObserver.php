<?php

namespace App\Observers;

use App\Jobs\UpdatePurchaseRequisitionStatusJob;
use App\Models\PurchaseOrderHeader;

class PurchaseOrderObserver
{
    /**
     * Handle the PurchaseOrderHeader "created" event.
     */
    public function created(PurchaseOrderHeader $purchaseOrderHeader): void
    {
        $hasPrReference = $purchaseOrderHeader->details()->whereNotNull('pr_detail_id')->exists();

        if ($hasPrReference) {
            UpdatePurchaseRequisitionStatusJob::dispatch($purchaseOrderHeader);
        }
    }

    /**
     * Handle the PurchaseOrderHeader "updated" event.
     */
    public function updated(PurchaseOrderHeader $purchaseOrderHeader): void
    {
        //
    }

    /**
     * Handle the PurchaseOrderHeader "deleted" event.
     */
    public function deleted(PurchaseOrderHeader $purchaseOrderHeader): void
    {
        //
    }

    /**
     * Handle the PurchaseOrderHeader "restored" event.
     */
    public function restored(PurchaseOrderHeader $purchaseOrderHeader): void
    {
        //
    }

    /**
     * Handle the PurchaseOrderHeader "force deleted" event.
     */
    public function forceDeleted(PurchaseOrderHeader $purchaseOrderHeader): void
    {
        //
    }
}
