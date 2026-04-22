<?php

namespace App\Models;

use App\Blameable;
use App\HasCodeGenerator;
use App\Models\Scopes\CompanyScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Customer extends Model
{
    use Blameable, HasCodeGenerator, HasFactory, HasRoles, SoftDeletes;

    // protected $with = ['companyList', 'paymentList', 'currencyList', 'paymentMethodList'];

    protected $fillable = [
        'company_id',
        'category',
        'is_active',
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
        'short_name',
        'currency_id',
        'payment_method_id',
        'remark',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'vat' => 'integer',
        'is_active' => 'boolean',
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
            'is_active' => 'boolean',
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
            'deleted_at' => 'datetime',
        ];
    }

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
        return $this->belongsTo(Currency::class, 'currency_id')->where('is_active', '1')->orderBy('code', 'asc');
    }

    public function paymentMethodList(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id')->where('deleted_at', null)->where('is_active', 1);
    }

    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope);
        static::creating(function ($supplier) {
            $supplier->code = self::generateAutoCode(
                tableName: 'customers',
                columnName: 'code',
                prefix: 'CUST',
                digits: 5,
                separator: '-'
            );
        });
    }
}
