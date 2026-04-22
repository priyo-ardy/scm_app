<?php

namespace App\Models;

use App\Blameable;
use App\HasCodeGenerator;
use App\Models\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Workshop extends Model
{
    use Blameable, HasCodeGenerator, HasFactory, HasRoles, SoftDeletes;

    protected $fillable = [
        'company_id',
        'code',
        'name',
        'branch_id',
        'location_detail',
        'pic_id',
        'phone',
        'remarks',
        'is_active',
        'created_by',
        'updated_by',
    ];

    // protected $with = [
    //     'branch',
    //     'user'
    // ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pic_id');
    }

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
        static::creating(function ($workshop) {
            $workshop->code = self::generateAutoCode(
                tableName: 'workshops',
                columnName: 'code',
                prefix: 'WRK',
                digits: 5,
                separator: '-'
            );
        });
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
