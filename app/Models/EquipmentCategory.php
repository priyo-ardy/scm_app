<?php

namespace App\Models;

use App\Blameable;
use App\HasCodeGenerator;
use App\Models\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasPermissions;

class EquipmentCategory extends Model
{
    use HasCodeGenerator, HasFactory, HasPermissions, Blameable, SoftDeletes;

    protected $fillable = [
        'company_id',
        'code',
        'name',
        'prefix',
        'icon',
        'description',
        'is_active',
        'created_by',
        'updated_by'
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
        ];
    }

    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope);
        static::creating(function ($category) {
            $category->code = self::generateAutoCode(
                tableName: 'equipment_categories',
                columnName: 'code',
                prefix: 'EQT',
                digits: 5,
                separator: '-'
            );
        });
    }

    public function companyList(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
