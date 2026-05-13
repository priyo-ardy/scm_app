<?php

namespace App\Jobs;

use App\Models\PurchaseOrderHeader;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UpdateAmountPoHeader implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected PurchaseOrderHeader $header)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $totals = $this->header->details()
            ->selectRaw('
                COALESCE(SUM(amount), 0) as amount,
                COALESCE(SUM(discount_amount), 0) as discount,
                COALESCE(SUM(tax_amount), 0) as tax,
                COALESCE(SUM(total_amount), 0) as total
            ')
            ->first();

        $this->header->newQuery()->where('id', $this->header->id)->update([
            'amount'       => $totals->amount,
            'total_discount' => $totals->discount,
            'tax_amount'   => $totals->tax,
            'total_amount' => $totals->total,
        ]);
    }
}
