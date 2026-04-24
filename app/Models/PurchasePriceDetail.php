<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class PurchasePriceDetail extends Model
{
    use HasFactory, HasRoles, SoftDeletes, Blameable;

    protected $fillable = [
        'header_id',
        'material_id',
        'unit_id',
        'unit_id',
        'from_qty',
        'to_qty',
        'unit_price',
        'unit_price_after_tax',
        'tax_rate',
        'effective_date',
        'expired_date',
        'is_active',
        'remark',
        'created_by ',
        'updated_by '
    ];

    protected function casts(): array
    {
        return [
            'from_qty'              => 'decimal:4',
            'to_qty'                => 'decimal:4',
            'unit_price'            => 'decimal:4',
            'unit_price'            => 'decimal:4',
            'unit_price_after_tax'  => 'decimal:4',
            'unit_price_after_tax'  => 'decimal:4',
            'tax_rate'              => 'decimal:2',
            'effective_date'        => 'date',
            'expired_date'          => 'date',
            'is_active'             => 'boolean',
            'updated_at'            => 'datetime:Y-m-d H:i:s',
            'deleted_at'            => 'datetime',
        ];
    }

    public function materialList(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'material_id')->where('status', 'active')->orderBy('code', 'asc');
    }

    public function unitList(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id')->where('is_active', true)->orderBy('code', 'asc');
    }
}
