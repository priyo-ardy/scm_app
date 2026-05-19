<?php

namespace App\Models;

use App\Blameable;
use App\HasCodeGenerator;
use App\Models\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasPermissions;

class Equipment extends Model
{
    use Blameable, HasCodeGenerator, HasFactory, HasPermissions, SoftDeletes;

    protected $table = 'equipments';

    // protected $with = ['companyList', 'category', 'branchList', 'tonnageList', 'workshopList'];

    protected $fillable = [
        'company_id',      // Baru ditambahkan
        'branch_id',       // Baru ditambahkan
        'category_id',
        'code',
        'equipment_no',
        'name',
        'specification',
        'tonnage_id',      // Diperbaiki (sebelumnya 'tonnage')
        'brand',
        'model_number',
        'serial_number',
        'purchase_date',
        'machine_rate',
        'status',
        'installation_date',
        'total_shots',
        'last_maintenance',
        'avatar',
        'workshop_id',     // Diperbaiki (sebelumnya typo 'workhsop_id')
        'description',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
        ];
    }

    public function companyList(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id')->where('deleted_at', null)->orderBy('name', 'asc');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(EquipmentCategory::class, 'category_id')->where('is_active', 1)->orderBy('name', 'asc');
    }

    public function branchList(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id')->where('is_active', 1)->orderBy('name', 'asc');
    }

    public function tonnageList(): BelongsTo
    {
        return $this->belongsTo(Tonnage::class, 'tonnage_id')->where('is_active', 1)->orderBy('name', 'asc');
    }

    public function workshopList(): BelongsTo
    {
        return $this->belongsTo(Workshop::class, 'workshop_id')->where('is_active', 1)->orderBy('name', 'asc');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public static function generateCurrentCode($categoryId)
    {
        if (! $categoryId) {
            return null;
        }

        $category = EquipmentCategory::find($categoryId);
        $prefix = $category?->prefix ?? 'EQP';

        // Panggil Trait yang sudah dimodifikasi tadi
        return static::generateAutoCode(
            tableName: 'equipments',
            columnName: 'code',
            prefix: $prefix,
            digits: 3,
            separator: '-'
        );
    }

    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope);
        static::creating(function ($model) {
            DB::transaction(function () use ($model) {
                $category = EquipmentCategory::find($model->category_id);
                $prefix = $category?->prefix ?? 'EQP';

                $model->code = static::generateAutoCode(
                    tableName: 'equipments',
                    columnName: 'code',
                    prefix: $prefix,
                    digits: 6,
                    separator: '-'
                );
            });
        });
    }
}
