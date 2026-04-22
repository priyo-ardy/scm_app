<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasRoles;

class ExchangeRate extends Model
{
    use Blameable, HasFactory, HasRoles;

    protected $fillable = [
        'currency_id',
        'rate_date',
        'rates',
        'note',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'rates' => 'integer',
            'rate_date' => 'date',
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
        ];
    }

    // protected $with = ['currency', 'user'];

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
