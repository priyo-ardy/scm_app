<?php

namespace App\Models;

use App\Blameable;
use App\HasCodeGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasPermissions;

class Material extends Model
{
    use HasFactory, HasPermissions, HasCodeGenerator, Blameable;

    protected $fillable = [];

    protected function casts(): array
    {
        return [
            'images' => 'array',
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
        ];
    }
}
