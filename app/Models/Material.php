<?php

namespace App\Models;

use App\Blameable;
use App\HasCodeGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasPermissions;

class Material extends Model
{
    use HasFactory, HasPermissions, HasCodeGenerator, Blameable;

    protected $fillable = [];

    protected function casts(): array
    {
        return [
            // --- JSON / ARRAY ---
            'images' => 'array',

            // --- BOOLEAN (UI Toggle Filament) ---
            'enable_min_stock' => 'boolean',
            'enable_safety_stock' => 'boolean',
            'enable_max_stock' => 'boolean',
            'enable_expired' => 'boolean',
            'is_hazardous' => 'boolean',
            'is_inspection_required' => 'boolean',

            // --- DECIMAL (Untuk Akurasi Perhitungan) ---
            'unit_conversion_rate' => 'decimal:4',
            'net_weight' => 'decimal:2',
            'gross_weight' => 'decimal:2',
            'sprue' => 'decimal:2',
            'cycle_time' => 'decimal:2',
            'min_stock' => 'decimal:2',
            'safety_stock' => 'decimal:2',
            'max_stock' => 'decimal:2',
            'reorder_point' => 'decimal:2',
            'carton_length' => 'decimal:4',
            'carton_width' => 'decimal:4',
            'carton_height' => 'decimal:4',
            'last_purchase_price' => 'decimal:2',
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
        ];
    }

    public function companyList(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id')->where('deleted_at', null)->orderBy('name', 'asc');
    }

    public function categoryList(): BelongsTo
    {
        return $this->belongsTo(MaterialCategory::class, 'category_id');
    }

    public function workshopList(): BelongsTo
    {
        return $this->belongsTo(Workshop::class, 'workshop_id')->where('is_active', '1')->orderBy('code', 'asc');
    }

    public function unitList(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id')->where('is_active', '1')->orderBy('code', 'asc');
    }

    public function purchaseUnitList(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'purchase_unit_id')->where('is_active', '1')->orderBy('code', 'asc');
    }

    public function dimensionUnitList(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'dimension_unit_id')->where('is_active', '1')->orderBy('code', 'asc');
    }

    public function supplierList(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id')->where('deleted_at', null)->orderBy('name', 'asc');
    }

    public function tonnageList(): BelongsTo
    {
        return $this->belongsTo(Tonnage::class, 'tonnage_id')->where('is_active', '1')->orderBy('code', 'asc');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
