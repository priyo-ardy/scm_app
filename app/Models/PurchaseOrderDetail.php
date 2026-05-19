<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasRoles;

class PurchaseOrderDetail extends Model
{
    use Blameable, HasFactory, HasRoles;

    protected $fillable = [
        'id',
        'po_id',
        'order',
        'pr_detail_id',
        'material_id',
        'unit_id',
        'qty',
        'qty_remaining',
        'unit_price',
        'amount',
        'tax_rate',
        'tax_amount',
        'price_after_tax',
        'discount_rate',
        'discount_amount',
        'price_after_discount',
        'total_amount',
        'row_status',
        'is_closed',
        'delivery_date',
        'remark',
        'created_at',
        'updated_at',
    ];

    protected function casts()
    {
        return [
            'qty' => 'double',
            'qty_remaining' => 'double',
            'unit_price' => 'double',
            'amount' => 'double',
            'tax_rate' => 'double',
            'tax_amount' => 'double',
            'price_after_tax' => 'double',
            'discount_rate' => 'double',
            'discount_amount' => 'double',
            'price_after_discount' => 'double',
            'total_amount' => 'double',
            'is_closed' => 'boolean',
        ];
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'material_id');
    }

    public function units(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function detail(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrderHeader::class, 'po_id');
    }

    protected static function booted()
    {
        static::created(function ($mode) {});
    }
}
