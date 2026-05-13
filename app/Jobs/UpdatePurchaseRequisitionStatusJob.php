<?php

namespace App\Jobs;

use App\Models\PurchaseOrderDetail;
use App\Models\PurchaseOrderHeader;
use App\Models\PurchaseRequisitionDetail;
use App\Models\PurchaseRequisitionHeader;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdatePurchaseRequisitionStatusJob implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(protected PurchaseOrderHeader $purchaseOrder) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (!$this->purchaseOrder->exists) {
            return;
        }

        DB::transaction(function () {
            $poDetails = $this->purchaseOrder->details;

            if ($poDetails->isEmpty()) {
                return;
            }

            $affectedPrHeaderIds = [];

            foreach ($poDetails as $poDetail) {
                if (empty($poDetail->pr_detail_id)) {
                    continue;
                }

                $prDetail = PurchaseRequisitionDetail::where('id', $poDetail->pr_detail_id)->lockForUpdate()->first();

                if ($prDetail) {
                    $affectedPrHeaderIds[] = $prDetail->purchase_requisition_header_id;

                    $prDetail->decrement('qty_remaining', $poDetail->qty);
                    if ($prDetail->qty_remaining <= 0) {
                        $prDetail->update(['qty_ordered' => $poDetail->qty, 'item_status' => 'closed', 'is_closed' => true]);
                    }
                }
            }

            $uniquePrHeaderIds = array_unique($affectedPrHeaderIds);

            foreach ($uniquePrHeaderIds as $prHeaderId) {
                $prHeader = PurchaseRequisitionHeader::find($prHeaderId);

                if ($prHeader) {
                    // Cek apakah masih ada detail yang statusnya bukan 'closed'
                    $hasOpenItems = $prHeader->details()
                        ->where(function ($query) {
                            $query->where('item_status', '!=', 'closed')
                                ->orWhere('is_closed', false);
                        })
                        ->exists();

                    // Jika TIDAK ADA lagi item yang open, maka tutup headernya
                    if (!$hasOpenItems) {
                        $prHeader->update([
                            'doc_status' => 'closed',
                            'is_closed' => true
                        ]);
                    }
                }
            }
        });
    }

    public function failed(\Throwable $exception): void
    {
        Log::error("Gagal update qty PR untuk PO ID: {$this->purchaseOrder->id}. Error: {$exception->getMessage()}");

        $recipient = User::find($this->purchaseOrder->created_by);

        if ($recipient) {
            Notification::make()
                ->title('System error')
                ->body('Failed to update purchase requisition data')
                ->danger()
                ->persistent()
                ->actions([
                    Action::make('view')
                        ->label('See Purchase Order')
                        ->url(fn() => "/purchase-orders/{$this->purchaseOrder->id}/view")
                        ->button()
                ])
                ->sendToDatabase($recipient);
        }
    }
}
