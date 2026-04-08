<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApprovalFlow extends Model
{
    protected $fillable = ['code', 'name'];


    public function steps()
    {
        return $this->hasMany(ApprovalStep::class)->orderBy('order');
    }
}
