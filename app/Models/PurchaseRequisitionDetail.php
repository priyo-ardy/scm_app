<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasRoles;

class PurchaseRequisitionDetail extends Model
{
    use HasFactory, HasRoles, Blameable;

    protected $fillable = [
        'purchase_requisition_header_id',
        'material_id',
        'unit_id',
        'qty',
        'qty_approved',
        'qty_ordered',
        'estimated_price',
        'subtotal',
        'supplier_id',
        'arrival_date',
        'item_status',
        'remark',
        'created_by',
        'updated_by',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'material_id');
    }

    public function units(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
