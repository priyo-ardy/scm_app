<?php

namespace App\Models;

use App\HasCodeGenerator;
use App\Models\Scopes\CompanyScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Branch extends Model
{
    use HasCodeGenerator, HasFactory, HasRoles, SoftDeletes;

    // protected $with = ['company'];

    protected $fillable = [
        'company_id',
        'code',
        'name',
        'category',
        'phone_ext',
        'manager_name',
        'total_manpower',
        'address',
        'map_url',
        'is_active',
    ];

    protected $casts = [
        'category' => 'string',
        'map_url' => 'array',
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
            'deleted_at' => 'datetime',
        ];
    }

    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope);
        static::creating(function ($model) {
            $model->code = self::generateAutoCode(
                tableName: 'branches',
                columnName: 'code',
                prefix: 'PLT',
                digits: 3,
                separator: '-'
            );
        });
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
