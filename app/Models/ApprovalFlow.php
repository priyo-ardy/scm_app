<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasRoles;

class ApprovalFlow extends Model
{
    use HasFactory, HasRoles, Blameable;

    protected $fillable = ['code', 'name', 'remark', 'created_by', 'updated_by'];

    public function steps()
    {
        return $this->hasMany(ApprovalStep::class, 'approval_flow_id', 'id')->orderBy('order');
    }
}
