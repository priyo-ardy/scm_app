<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasRoles;

class PurchaseOrderDetail extends Model
{
    use HasFactory, HasRoles, Blameable;

    protected $fillable = [
        'po_id',
        'order',
        'material_id',
        'unit_id',
        'qty',
        'qty_remaining',
        'unit_price',
        'tax_rate',
        'tax_amount',
        'discount_rate',
        'discount_amount',
        'total_amount',
        'row_status',
        'is_closed',
        'delivery_date',
        'remark',
    ];

    protected function casts()
    {
        return [
            'qty' => 'decimal: 15,4',
            'qty_remaining' => 'decimal: 5,2',
            'unit_price' => 'decimal: 15,4',
            'tax_rate' => 'decimal:5, 2',
            'tax_amount' => 'decimal:15,4',
            'discount_rate' => 'decimal:5,2',
            'discount_amount' => 'decimal:15,4',
            'total_amount' => 'decimal:15,4',
            'is_closed' => 'boolean'
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
