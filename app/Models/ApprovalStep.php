<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApprovalStep extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
