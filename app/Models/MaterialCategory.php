<?php

namespace App\Models;

use App\HasCodeGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasPermissions;

class MaterialCategory extends Model
{
    use HasFactory, HasPermissions, HasCodeGenerator;

    protected $fillable = [
        'code',
        'name',
        'parent_id',
        'sort_order',
        'remark',
        'is_active'
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
        ];
    }

    public function header(): BelongsTo
    {
        return $this->belongsTo(MaterialCategory::class, 'parent_id');
    }

    protected static function booted()
    {
        static::saving(function ($category) {
            // Cek: Apakah parent_id berubah?
            // isDirty('parent_id') akan TRUE jika user mengganti parent di form.
            $parentChanged = $category->isDirty('parent_id');

            // Cek: Apakah ini record baru?
            $isNew = !$category->exists;

            // KITA HANYA GENERATE ULANG JIKA:
            // 1. Punya parent_id DAN (Data Baru ATAU Parent-nya diganti)
            if ($category->parent_id && ($isNew || $parentChanged)) {
                $parent = MaterialCategory::find($category->parent_id);

                // Cari nomor urut terakhir dari anak-anak si parent tersebut
                $lastChild = MaterialCategory::where('parent_id', $category->parent_id)
                    ->where('id', '!=', $category->id) // Hindari menghitung diri sendiri
                    ->latest('code') // Urutkan berdasarkan kode terakhir
                    ->first();

                if ($lastChild) {
                    // Ambil angka terakhir setelah titik
                    $segments = explode('.', $lastChild->code);
                    $nextNumber = (int) end($segments) + 1;
                } else {
                    // Jika parent ini belum punya anak sama sekali
                    $nextNumber = 1;
                }

                // Set kode baru: misal "2" + "." + "1" = "2.1"
                $category->code = $parent->code . '.' . $nextNumber;
            }

            // Jika parent_id tidak berubah, variabel $category->code tidak kita sentuh,
            // sehingga kodenya tetap pakai yang lama yang tersimpan di database.
        });
    }
}
