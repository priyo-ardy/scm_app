<?php

namespace App\Models;

use App\HasCodeGenerator;
use App\LogsAllActivities;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Supplier extends Authenticatable
{
    use SoftDeletes, HasFactory, HasRoles, HasCodeGenerator;
    // use LogsAllActivities;

    protected $fillable = [
        'code',
        'name',
        'address',
        'email',
        'phone',
        'fax',
        'website',
        'contact_person',
        'contact_person_email',
        'contact_person_phone',
        'registration_no',
        'tax_no',
        'vat',
        'avatar',
        'bank_name',
        'bank_account_no',
        'bank_account_name',
        'payment_method',
        'remark',
    ];

    protected $casts = [
        'vat' => 'integer',
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
            'vat' => 'integer',
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
            'deleted_at' => 'datetime',
        ];
    }

    protected static function booted()
    {
        static::creating(function ($supplier) {
            $supplier->code = self::generateAutoCode(
                tableName: 'suppliers',
                columnName: 'code',
                prefix: 'SUP',
                digits: 5,
                separator: '-'
            );
        });
    }
}
