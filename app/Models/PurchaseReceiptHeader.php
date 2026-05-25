<?php

namespace App\Models;

use App\Blameable;
use App\HasCodeGenerator;
use App\Jobs\UpdateOutstandingPurchaseOrder;
use App\Models\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;

class PurchaseReceiptHeader extends Model
{
    use Blameable, HasCodeGenerator, HasFactory, HasRoles;

    protected $fillable = [
        'company_id',
        'code',
        'doc_date',
        'received_date',
        'doc_status',
        'is_closed',
        'supplier_id',
        'currency_id',
        'exchange_rate',
        'delivery_note_number',
        'vehicle_number',
        'qc_status',
        'received_by',
        'print_count',
        'remark',
        'created_by',
        'updated_by',
    ];

    protected function casts()
    {
        return [
            'doc_date' => 'date',
            'received_date' => 'date',
            'is_closed' => 'boolean',
            'print_count' => 'integer',
            'exchange_rate' => 'double',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(PurchaseReceiptDetail::class, 'receipt_id');
    }

    protected static function booted()
    {
        static::addGlobalScope(CompanyScope::class);
        static::creating(function ($model) {
            $company = $model->company_id;
            $model->code = self::generateCodeWithDateByCompany(
                tableName: 'purchase_receipt_headers',
                columnName: 'code',
                prefix: 'PC',
                digits: 8,
                separator: '-',
                companyId: $company
            );
        });
    }
}
