<?php

namespace App\Models;

use App\Blameable;
use App\HasCodeGenerator;
use App\Models\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasRoles;

class Department extends Model
{
    use HasFactory, HasRoles, HasCodeGenerator, Blameable;

    protected $fillable = [
        'company_id',
        'code',
        'name',
        'manager_id',
        'remark',
        'is_active',
        'cost_center_code',
        'created_by',
        'updated_by'
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
            'deleted_at' => 'datetime',
        ];
    }

    public function companyList(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function managerList(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function creatorList(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updaterList(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope);
        static::creating(function ($model) {
            $company_id = $model->company_id;
            $model->code = self::generateCodeBasedOnCompany(
                tableName: 'departments',
                columnName: 'code',
                prefix: 'DPT',
                digits: 5,
                separator: '-',
                companyId: $company_id
            );
        });
    }
}
