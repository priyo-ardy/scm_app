<?php

namespace App\Jobs;

use App\Models\PurchaseOrderDetail;
use App\Models\PurchaseOrderHeader;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class UpdateOutstandingPurchaseOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected int $poDetailId,
        protected float $qtyReceived,
        protected string $action
    ) {}

    public function handle()
    {
        DB::transaction(function () {
            if ($poDetail = PurchaseOrderDetail::where('id', $this->poDetailId)->lockForUpdate()->first()) {

                if ($this->action === 'decrement') {
                    $isClosed = ($poDetail->qty_remaining - $this->qtyReceived) <= 0;

                    $poDetail->decrement('qty_remaining', $isClosed ? $poDetail->qty_remaining : $this->qtyReceived, [
                        'row_status' => $isClosed ? 'closed' : 'partial',
                        'is_closed'  => $isClosed
                    ]);
                } elseif ($this->action === 'increment') {
                    $maxAllowedIncrement = max(0, ($poDetail->qty_order ?? 0) - $poDetail->qty_remaining);
                    $actualIncrement = min($this->qtyReceived, $maxAllowedIncrement);

                    $isFullyOpen = ($poDetail->qty_remaining + $actualIncrement) >= ($poDetail->qty_order ?? 0);

                    $poDetail->increment('qty_remaining', $actualIncrement, [
                        'row_status' => $isFullyOpen ? 'open' : 'partial',
                        'is_closed'  => false
                    ]);

                    if ($poDetail->purchase_order_header_id) {
                        PurchaseOrderHeader::where('id', $poDetail->purchase_order_header_id)
                            ->update(['is_closed' => false]);
                    }
                }
            }
        });
    }
}
