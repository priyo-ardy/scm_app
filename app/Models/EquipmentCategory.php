<?php

namespace App\Models;

use App\HasCodeGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasPermissions;

class EquipmentCategory extends Model
{
    use HasCodeGenerator, HasFactory, HasPermissions;

    protected $fillable = [
        'code',
        'name',
        'prefix',
        'icon',
        'description',
        'is_active',
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
}
