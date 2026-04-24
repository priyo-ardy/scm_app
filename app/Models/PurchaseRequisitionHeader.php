<?php

namespace App\Models;

use App\Blameable;
use App\HasCodeGenerator;
use App\Models\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class PurchaseRequisitionHeader extends Model
{
    use HasFactory, HasRoles, HasCodeGenerator, Blameable, SoftDeletes;

    protected $fillable = [
        'company_id',
        'code',
        'department_id',
        'requester_id',
        'doc_date',
        'priority',
        'doc_status',
        'required_date',
        'reject_reason',
        'reason',
        'created_by',
        'updated_by',
        'approved_by',
        'approved_at'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id')->orderBy('code', 'asc');
    }

    public function requestor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requester_id')->orderBy('name', 'asc');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by')->orderBy('name', 'asc');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by')->orderBy('name', 'asc');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by')->where('is_active', true)->orderBy('name', 'asc');
    }

    public function details(): HasMany
    {
        return $this->hasMany(PurchaseRequisitionDetail::class, 'purchase_requisition_header_id');
    }

    protected $casts = [
        'doc_date' => 'date',
        'required_date' => 'date',
        'approved_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::addGlobalScope(CompanyScope::class);
        static::creating(function ($model) {
            $company = $model->company_id;
            $model->code = self::generateCodeWithDateByCompany(
                tableName: 'purchase_requisition_headers',
                columnName: 'code',
                prefix: 'PR',
                digits: 8,
                separator: '-',
                companyId: $company
            );
        });
    }
}
