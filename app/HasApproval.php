<?php

namespace App;

use App\Models\ApprovalLog;

trait HasApproval
{
    public function approvalLog()
    {
        return $this->morphOne(ApprovalLog::class, 'approvable');
    }

    public function getApprovalStatus(): string
    {
        return $this->approvalLog?->status ?? 'draft';
    }
}
