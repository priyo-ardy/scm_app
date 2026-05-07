<?php

namespace App\Models;

use App\Blameable;
use App\HasCodeGenerator;
use App\Jobs\InitializeApprovalJob;
use App\Models\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasRoles;

class PurchaseOrderHeader extends Model
{
    use HasFactory, HasRoles, HasCodeGenerator, Blameable;

    protected $fillable = [
        'company_id',
        'code',
        'doc_date',
        'doc_status',
        'department_id',
        'supplier_id',
        'total_amount',
        'tax_amount',
        'currency_id',
        'exchange_rate',
        'delivery_date',
        'payment_term_id',
        'shipping_address',
        'is_printed',
        'printed_count',
        'purchase_requisition_id',
        'external_ref_no',
        'approved_at',
        'approved_by',
        'rejected_at',
        'rejected_by',
        'reject_reason',
        'cancel_reason',
        'remark',
        'created_by',
        'updated_by',
    ];

    protected function casts()
    {
        return [
            'total_amount' => 'decimal: 15,4',
            'tax_amount' => 'decimal: 5,2',
            'exchange_rate' => 'decimal: 15,4',
            'is_printed' => 'boolean',
            'printed_count' => 'integer',
            'doc_date' => 'date',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function paymentTerm(): BelongsTo
    {
        return $this->belongsTo(PaymentTerm::class, 'payment_term_id');
    }

    public function purchaseRequisition(): BelongsTo
    {
        return $this->belongsTo(PurchaseRequisitionHeader::class, 'purchase_requisition_id');
    }

    protected static function booted()
    {
        static::addGlobalScope(CompanyScope::class);
        static::creating(function ($model) {
            $company = $model->company_id;
            $model->code = self::generateCodeWithDateByCompany(
                tableName: 'purchase_order_headers',
                columnName: 'code',
                prefix: 'PO',
                digits: 8,
                separator: '-',
                companyId: $company
            );
        });

        // static::created(function ($model) {
        //     InitializeApprovalJob::dispatch($model, 'purchase_order');
        // });
    }
}
