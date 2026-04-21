<?php

namespace App\Models;

use App\HasCodeGenerator;
use App\LogsAllActivities;
use App\Models\Scopes\CompanyScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Supplier extends Authenticatable
{
    use HasCodeGenerator, HasFactory, HasRoles, SoftDeletes;
    // use LogsAllActivities;

    protected $fillable = [
        'company_id',
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
        'bank_name',
        'bank_account_no',
        'bank_account_name',
        'avatar',
        'payment_term_id',
        'is_active',
        'category',
        'remark',
        'default_currency',
    ];

    protected $casts = [
        'vat' => 'integer',
        'is_active' => 'boolean'
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

    protected $with = [
        'companyList',
        'paymentList',
        'currencyList'
    ];

    public function companyList(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id')->where('deleted_at', null)->orderBy('name', 'asc');
    }

    public function paymentList(): BelongsTo
    {
        return $this->belongsTo(PaymentTerm::class, 'payment_term_id');
    }

    public function currencyList(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'default_currency')->where('is_active', '1')->orderBy('code', 'asc');
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $companyId = $model->company_id;

            if ($companyId) {
                $model->code = self::generateCodeBasedOnCompany(
                    tableName: 'suppliers',
                    columnName: 'code',
                    prefix: 'SUP',
                    digits: 6,
                    separator: '-',
                    companyId: $companyId
                );
            }
        });

        static::addGlobalScope(new CompanyScope);
    }
}
