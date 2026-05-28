<?php

namespace App\Jobs;

use App\Models\PurchaseOrderDetail;
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
        protected float $qtyReceived
    ) {}

    public function handle()
    {
        DB::transaction(function () {
            $poDetail = PurchaseOrderDetail::where('id', $this->poDetailId)
                ->lockForUpdate()
                ->first();

            if ($poDetail) {
                $poDetail->decrement('qty_remaining', $this->qtyReceived);
            }
        });
    }
}
