<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class ApprovalLog extends Model
{
    use HasFactory, HasRoles, Blameable;

    protected $fillable = [
        'approval_flow_id',
        'document_type',
        'document_id',
        'current_step_order',
        'current_approver_id',
        'status',
        'processed_at'
    ];
}
