<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Company extends Model
{
    use SoftDeletes, HasFactory, HasRoles;

    protected $fillable = [
        'code',
        'name',
        'legal_name',
        'slug',
        'email',
        'phone',
        'fax',
        'website',
        'address',
        'postal_code',
        'tax_id',
        'tax_address',
        'is_pkp',
        'bank_name',
        'bank_account',
        'bank_beneficiary',
        'logo',
        'favicon',
        'currency',
        'timezone'
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
            'deleted_at' => 'datetime',
        ];
    }
}
