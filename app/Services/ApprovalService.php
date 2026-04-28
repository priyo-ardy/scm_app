<?php

namespace App\Services;

use App\Models\ApprovalFlow;
use App\Models\ApprovalStep;
use App\Models\ApprovalLog;
use Illuminate\Database\Eloquent\Model;

class ApprovalService
{
    public function initializeApproval(Model $record, string $flowCode): void
    {
        $steps = ApprovalStep::where('approval_flow_code', $flowCode)->first();

        if (!$steps) {
            throw new \Exception("Approval step for {$flowCode} is not found");
        }

        foreach ($steps as $index => $row) {
            ApprovalLog::create([
                'approvable_type' => get_class($record),
                'approvable_id' => $record->id,
                'approval_flow_id' => $row->approval_flow_id,
                'current_step_order' => $row->order,
                'current_role_needed' => $row->role_name,
                'approver_id' => $row->approver_id,
                'status' => ($index === 0) ? 'pending' : 'waiting',
            ]);
        }
    }
}
