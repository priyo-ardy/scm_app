<?php

namespace App;

use Spatie\Activitylog\Support\LogOptions;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\MassPrunable;

trait LogsAllActivities
{
    use LogsActivity, MassPrunable;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontLogIfAttributesChangedOnly(['updated_at', 'created_at'])
            ->setDescriptionForEvent(fn(string $eventName) => "Model " . class_basename($this) . " has been {$eventName}");
    }

    public function prunable()
    {
        // Menghapus log aktivitas yang sudah lebih dari 30 hari
        return static::where('created_at', '<=', now()->subDays(30));
    }
}
