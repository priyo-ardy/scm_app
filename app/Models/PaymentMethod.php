<?php

namespace App\Models;

use App\Blameable;
use App\HasCodeGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasPermissions;

class PaymentMethod extends Model
{
    use Blameable, HasCodeGenerator, HasFactory, HasPermissions, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'category_id',
        'type',
        'commission_fee',
        'payment_mode',
        'is_active',
        'description',
        'created_by',
        'updated_by',
    ];

    public function casts()
    {
        return [
            'commission_fee' => 'boolean',
        ];
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->code = self::generateAutoCode(
                tableName: 'payment_methods',
                columnName: 'code',
                prefix: 'PYM',
                digits: 5,
                separator: '-'
            );
        });
    }

    // protected $with = [
    //     'creatorList',
    //     'updaterList',
    //     'categoryList'
    // ];
    public function creatorList(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updaterList(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function categoryList(): BelongsTo
    {
        return $this->belongsTo(SettlementCategory::class, 'category_id')->where('deleted_at', null)->where('is_active', 1)->orderBy('name', 'asc');
    }
}
