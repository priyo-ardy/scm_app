<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasRoles;

class PurchaseReceiptDetail extends Model
{
    use Blameable, HasFactory, HasRoles;

    protected $fillable = [
        'receipt_id',
        'po_id',
        'po_detail_id',
        'material_id',
        'unit_id',
        'qty_ordered',
        'qty_received',
        'qty_rejected',
        'qty_remaining',
        'is_closed',
        'lot_number',
        'remark',
        'created_by',
        'updated_by',
    ];

    protected function casts()
    {
        return [
            'qty_ordered' => 'double',
            'qty_received' => 'double',
            'qty_rejected' => 'double',
            'qty_remaining' => 'double',
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

    public function details(): BelongsTo
    {
        return $this->belongsTo(PurchaseReceiptHeader::class, 'receipt_id');
    }
}
