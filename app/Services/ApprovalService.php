<?php

namespace App\Services;

use App\Models\ApprovalFlow;
use App\Models\ApprovalStep;
use App\Models\ApprovalLog;
use App\Models\Department;
use App\Models\Section;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class ApprovalService
{
    public function initializeApproval(Model $record, string $flowCode): void
    {
        $section_id = Session::get('section_id');
        $dept_id = Session::get('department_id');
        $user_id = Session::get('id');

        $documentName = ucwords(str_replace('_', ' ', strtolower($flowCode)));
        $flow = ApprovalFlow::where('code', $flowCode)->first();
        if (!$flow) {
            throw new \Exception("Approval flow for document {$documentName} is not found, please contact your administrator");
        }

        $steps = ApprovalStep::where('approval_flow_id', '=', $flow->id, 'and')
            ->orderBy('order', 'asc')
            ->get();

        if (!$steps) {
            throw new \Exception("Approval step for {$documentName} is not found");
        }

        foreach ($steps as $index => $row) {
            $approverId = null;

            switch ($row->approver_role) {
                case 'direct_user':
                    $approverId = $row->approver_id;
                    break;
                case 'section_head':
                    $section = Section::find($section_id);
                    $approverId = $section->section_head_id;
                    break;
                case 'manager_dept':
                    $dept = Department::find($dept_id);
                    $approverId = $dept->manager_id;
                    break;
                case 'finance':
                        $finance = User::where('role', 'finance')->first();
                        $approverId = $finance->id;
                    break;
                    case 'vice_gm':
                        $vice_gm = User::where('role', 'vice_gm')->first();
                        $approverId = $vice_gm->id;
                        break;
                    case 'gm':
                        $gm = User::where('role', 'gm')->first();
                        $approverId = $gm->id;
                        break;
            }

            if($approverId) {
                ApprovalLog::create([
                    'approval_flow_id' => $flow->id,
                    'document_type' => get_class($record),
                    'header_id' => $record->id,
                    'flow_code' => $flowCode,
                    'document_id' => $record->id,
                    'current_step_order' => $row->order,
                    'current_approver_id' => $approverId,
                    'status' => 'pending',
                    'processed_at' => null
                ]);
            }
        }
    }
}
