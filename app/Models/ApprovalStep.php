<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApprovalStep extends Model
{
    protected $fillable = [
        'approval_flow_id',
        'approval_flow_code',
        'order',
        'role_name',
        'approver_id',
        'created_at',
        'updated_at',
    ];

    public function flow(): BelongsTo
    {
        return $this->belongsTo(ApprovalFlow::class, 'approval_flow_code', 'code');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    protected static function booted()
    {
        static::creating(function ($step) {
            if ($step->approval_flow_id && !$step->approval_flow_code) {
                $flow = ApprovalFlow::find($step->approval_flow_id);

                if ($flow) {
                    $step->approval_flow_code = $flow->code;
                }
            }
        });
    }
}
