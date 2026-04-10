<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
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
}
