<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasPermissions;

class Tonnage extends Model
{
    use HasFactory, HasPermissions;

    protected $fillable = [
        'code',
        'name',
        'clamping_force_kn',
        'remark',
        'is_active',
        'std_dbugging',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
        ];
    }
}
