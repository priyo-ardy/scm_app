<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CompanyScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {

        if (app()->runningInConsole()) {
            return;
        }

        if (Auth::check()) {
            $companyId = Session::get('active_company');

            if (! is_null($companyId)) {
                $builder->where('company_id', $companyId);
            }
        }
    }
}
