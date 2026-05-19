<?php

namespace App\Jobs;

use App\Services\ApprovalService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InitializeApprovalJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    // use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public $model,
        public string $flowCode,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(ApprovalService $approvalService): void
    {
        $approvalService->initializeApproval($this->model, $this->flowCode);
    }
}
