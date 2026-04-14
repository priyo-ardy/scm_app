<?php

namespace App;

use Illuminate\Support\Facades\Auth;

trait Blameable
{
    protected static function bootBlameable()
    {
        static::creating(function ($model) {
            // $model->created_by = Auth::id();
            if (Auth::check()) {
                $model->created_by = Auth::id();
                $model->updated_by = Auth::id();
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });
    }
}
