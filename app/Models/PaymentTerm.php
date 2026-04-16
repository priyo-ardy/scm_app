<?php

namespace App\Models;

use App\Blameable;
use App\HasCodeGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasPermissions;

class PaymentTerm extends Model
{
    use HasFactory, HasPermissions, HasCodeGenerator, Blameable, SoftDeletes;

    protected $fillable = [
        'code',
        'bill_period_basis',
        'name',
        'description',
        'is_active'
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'updated_at' => 'datetime:Y-m-d H:i:s',
            'deleted_at' => 'datetime',
        ];
    }

    protected static function booted()
    {
        static::creating(function ($payment_terms) {
            $payment_terms->code = self::generateAutoCode(
                tableName: 'payment_terms',
                columnName: 'code',
                prefix: 'PYT',
                digits: 5,
                separator: '-'
            );
        });
    }
}
