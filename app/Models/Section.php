<?php

namespace App\Models;

use App\Blameable;
use App\HasCodeGenerator;
use App\Models\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasRoles;

class Section extends Model
{
    use Blameable, HasCodeGenerator, HasFactory, HasRoles;

    protected $fillable = [
        'company_id',
        'department_id',
        'code',
        'name',
        'section_head_id',
        'is_active',
        'description',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function companyList(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function dept(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function sectionHead(): BelongsTo
    {
        return $this->belongsTo(User::class, 'section_head_id');
    }

    protected static function booted()
    {
        static::addGlobalScope(CompanyScope::class);
        static::creating(function ($model) {
            $company = $model->company_id;

            $model->code = self::generateCodeBasedOnCompany(
                tableName: 'sections',
                columnName: 'code',
                prefix: 'SCT',
                digits: 6,
                separator: '-',
                companyId: $company
            );
        });
    }

    public function getSectionById(int $sectionId)
    {
        return $this->whereId($sectionId)->first();
    }
}
