<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class ApprovalLog extends Model
{
    use Blameable, HasFactory, HasRoles;

    protected $fillable = [
        'approval_flow_id',
        'document_type',
        'flow_code',
        'header_id',
        'document_id',
        'current_step_order',
        'current_approver_id',
        'status',
        'processed_at',
    ];
}
