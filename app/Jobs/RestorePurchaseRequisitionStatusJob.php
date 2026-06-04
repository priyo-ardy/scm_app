<?php

namespace App\Jobs;

use App\Models\PurchaseRequisitionDetail;
use App\Models\PurchaseRequisitionHeader;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RestorePurchaseRequisitionStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected array $poDetailsData,
        protected ?int $createdByUserId = null
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (empty($this->poDetailsData)) {
            return;
        }

        DB::transaction(function () {
            $affectedPrHeadersIds = [];

            foreach ($this->poDetailsData as $poDetail) {
                if (empty($poDetail['pr_detail_id'])) {
                    continue;
                }

                $prDetail = PurchaseRequisitionDetail::where('id', $poDetail['pr_detail_id'])
                    ->lockForUpdate()
                    ->first();

                if ($prDetail) {
                    $affectedPrHeadersIds[] = $prDetail->purchase_requisition_header_id;

                    $newQtyRemaining = $prDetail->qty_remaining + $poDetail['qty'];
                    $newQtyOrdered = max(0, $prDetail->qty_ordered - $poDetail['qty']);

                    $updateData = [
                        'qty_remaining' => $newQtyRemaining,
                        'qty_ordered' => $newQtyOrdered
                    ];

                    if ($newQtyRemaining > 0) {
                        $updateData['item_status'] = 'open';
                        $updateData['is_closed'] = true;
                    }

                    $prDetail->update($updateData);
                }
            }

            $uniquePrHeaderIds = array_unique($affectedPrHeadersIds);
            foreach ($uniquePrHeaderIds as $prHeaderId) {
                $prHeader = PurchaseRequisitionHeader::find($prHeaderId);

                if ($prHeader) {
                    $hasOpenItems = $prHeader->details()
                        ->where('is_closed', false)
                        ->exists();

                    if ($hasOpenItems) {
                        $prHeader->update([
                            'doc_status' => 'approved',
                            'is_closed' => 'false'
                        ]);
                    }
                }
            }
        });
    }

    public function failed(\Throwable $exception): void
    {
        Log::error("Gagal mengembalikan qty PR saat PO dihapus. Error: {$exception->getMessage()}");

        if ($this->createdByUserId) {
            $recipient = User::find($this->createdByUserId);
            if ($recipient) {
                Notification::make()
                    ->title('System Error (Restoring PR)')
                    ->body('Failed to restore purchase requisition quantities after PO deletion.')
                    ->danger()
                    ->persistent()
                    ->sendToDatabase($recipient);
            }
        }
    }
}
