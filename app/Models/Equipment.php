<?php

namespace App\Models;

use App\HasCodeGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasPermissions;

class Equipment extends Model
{
    use HasFactory, HasPermissions, HasCodeGenerator;

    protected $table = 'equipments';

    protected $fillable = [
        'category_id',
        'code',
        'name',
        'location',
        'tonnage',
        'brand',
        'model_number',
        'serial_number',
        'purchase_date',
        'machine_rate',
        'status',
        'installation_date',
        'total_shots',
        'last_maintenance',
        'avatar',
        'description'
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(EquipmentCategory::class, 'category_id')->where('is_active', 1)->orderBy('name', 'asc');
    }

    public static function generateCurrentCode($categoryId)
    {
        if (!$categoryId) return null;

        $category = EquipmentCategory::find($categoryId);
        $prefix = $category?->prefix ?? 'EQP';

        // Panggil Trait yang sudah dimodifikasi tadi
        return static::generateAutoCode(
            tableName: 'equipments',
            columnName: 'code',
            prefix: $prefix,
            digits: 3,
            separator: '-'
        );
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            DB::transaction(function () use ($model) {
                $category = EquipmentCategory::find($model->category_id);
                $prefix = $category?->prefix ?? "EQP";

                $model->code = static::generateAutoCode(
                    tableName: 'equipments',
                    columnName: 'code',
                    prefix: $prefix,
                    digits: 6,
                    separator: '-'
                );
            });
        });
    }
}
