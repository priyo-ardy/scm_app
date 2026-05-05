<?php

namespace App\Models;

use App\Blameable;
use App\HasCodeGenerator;
use App\Models\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class PurchasePriceHeader extends Model
{
    use HasFactory, HasPermissions, HasRoles, HasCodeGenerator, SoftDeletes, Blameable;

    protected $fillable = [
        'company_id',
        'code',
        'name',
        'supplier_id',
        'currency_id',
        'approved_by',
        'approved_at',
        'is_active',
        'doc_status',
        'remark',
        'created_by',
        'updated_by'
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
            'deleted_at' => 'datetime:Y-m-d H:i:s',
        ];
    }

    public function companyList(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function supplierList(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id')->where('is_active', true)->where('deleted_at', null)->orderBy('name', 'asc');
    }

    public function currencyList(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id')->where('is_active', true)->where('deleted_at', null)->orderBy('code', 'asc');
    }

    public function approverList(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function creatorList(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updaterList(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function purchasePriceDetails(): HasMany
    {
        return $this->hasMany(PurchasePriceDetail::class, 'header_id');
    }

    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope);

        static::creating(function ($model) {
            $companyId = $model->company_id;

            if ($companyId) {
                $model->code = self::generateCodeWithDateByCompany(
                    tableName: 'purchase_price_headers',
                    columnName: 'code',
                    prefix: 'PRC',
                    digits: 6,
                    separator: '-',
                    companyId: $companyId
                );
            }
        });
    }
}
