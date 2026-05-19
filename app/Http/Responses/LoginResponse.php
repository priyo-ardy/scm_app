<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class LoginResponse implements Responsable
{
    public function toResponse($request): RedirectResponse|Redirector
    {
        $user = Auth::user();

        session([
            'department_id' => $user->department_id,
            'section_id' => $user->section_id,
        ]);

        return redirect()->intended(filament()->getUrl());
    }
}
