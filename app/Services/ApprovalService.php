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
        $documentName = ucwords(str_replace('_', ' ', strtolower($flowCode)));
        $flow = ApprovalFlow::where('code', '=', $flowCode, 'and')->first();
        if (!$flow) {
            throw new \Exception("Approval flow for document {$documentName} is not found, please contact your administrator");
        }

        $steps = ApprovalStep::where('approval_flow_id', '=', $flow->id, 'and')
            ->orderBy('order', 'asc')
            ->get();

        if (!$steps) {
            throw new \Exception("Approval step for {$documentName} is not found");
        }

        $data = [];

        foreach ($steps as $index => $row) {
            switch ($row->approver_role) {
                case 'direct_user':
                    $data[] = [
                        'approval_flow_id' => $flow->id,
                        'document_type' => get_class($record),
                        'document_id' => '', //harusnya terisi otomatis dari id dokumen yang disimpan
                        'current_step_order' => $row->order,
                        'current_approval_id' => $row->approver_id,
                        'status' => 'pending',
                        'processed_at' => null
                    ];
                    break;
                case 'section_head':
                    // Ini harus cek ke table user yang sectionnya adalah yang dikirim (section dan department akan disimpan pada session)
                    break;
                case 'dept_head':
                    // Ini harus cek ke table user yang dept_headnya adalah yang dikirim (section dan department akan disimpan pada session)
                    break;
                case 'manager_dept':
                    // Ini harus cek ke table department dan cek siapa managernya
                    break;
                case 'finance':
                    // Ini harus cek ke table user yang role nya adalah finance
                    break;
                case 'vice_gm':
                    // Ini harus cek ke table user yang role nya adalah vice_gm
                    break;
                case 'gm':
                    // Ini harus cek ke table user yang role nya adalah gm
                    break;
            }
        }
    }
}
