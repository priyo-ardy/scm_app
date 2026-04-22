<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Session;

class CompanyScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $companyId = Session::get('active_company');

        if (! is_null($companyId)) {
            $builder->where('company_id', $companyId);
        }
    }
}
