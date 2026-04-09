<?php

namespace App\Models;

use App\Blameable;
use App\HasCodeGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasRoles;

class Workshop extends Model
{
    use HasFactory, HasRoles, HasCodeGenerator;

    protected $fillable = [
        'code',
        'name',
        'branch_id',
        'location_detail',
        'pic_id',
        'phone',
        'remarks',
        'is_active'
    ];

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
}
