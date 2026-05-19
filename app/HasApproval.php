<?php

namespace App;

use App\Models\ApprovalFlow;

trait HasApproval
{
    public function approvalLog(string $approvalFlowCode)
    {
        // $approvalFlow = ApprovalFlow::where('code', '=', $approvalFlowCode, 'and')->first();
        // if(! $approvalFlow && $approvalFlow->id){
        //     throw
        // }
    }

    public function getApprovalStatus(): string
    {
        return $this->approvalLog?->status ?? 'draft';
    }
}
