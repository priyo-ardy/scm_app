<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasPermissions;

class Tonnage extends Model
{
    use HasFactory, HasPermissions, SoftDeletes, Blameable;

    protected $fillable = [
        'company_id',
        'code',
        'name',
        'clamping_force_kn',
        'remark',
        'is_active',
        'std_dbugging',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'clamping_force_kn' => 'decimal:2',
            'std_dbugging' => 'int',
            'is_active' => 'boolean',
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
        ];
    }

    public function companyList(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id')->orderBy('name', 'asc');
    }

    public function creatorList(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updaterList(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
