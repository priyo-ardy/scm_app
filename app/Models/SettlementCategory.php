<?php

namespace App\Models;

use App\Blameable;
use App\HasCodeGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasPermissions;

class SettlementCategory extends Model
{
    use Blameable, HasCodeGenerator, HasFactory, HasPermissions, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'is_active',
        'description',
        'created_by',
        'updated_by',
    ];

    public function casts()
    {
        return [
            'is_active' => 'boolean',
            'updated_at' => 'datetime:Y-m-d H:i:s',
            'deleted_at' => 'datetime',
        ];
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->code = self::generateAutoCode(
                tableName: 'settlement_categories',
                columnName: 'code',
                prefix: 'STC',
                digits: 5,
                separator: '-'
            );
        });
    }

    // protected $with = [
    //     'creatorList',
    //     'updaterList'
    // ];

    public function creatorList(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updaterList(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
