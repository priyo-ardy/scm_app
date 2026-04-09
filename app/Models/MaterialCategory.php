<?php

namespace App\Models;

use App\HasCodeGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasPermissions;

class MaterialCategory extends Model
{
    use HasFactory, HasPermissions, HasCodeGenerator;

    protected $fillable = [
        'code',
        'name',
        'prefix',
        'remark',
        'is_active'
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
                tableName: 'material_categories',
                columnName: 'code',
                prefix: 'MCTG',
                digits: 5,
                separator: '-'
            );
        });
    }
}
