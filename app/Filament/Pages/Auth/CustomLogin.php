<?php

namespace App\Filament\Pages\Auth;

use App\Models\User;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Auth\Pages\Login as BaseLogin;
// use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Validation\ValidationException;

class CustomLogin extends BaseLogin
{
    public function authenticate(): ?LoginResponse
    // public function authenticate(): ?LoginResponse
    {
        $data = $this->form->getState();

        $user = User::where('email', '=', $data['email'], 'and')->first();
        if ($user && ! $user->is_active) {
            throw ValidationException::withMessages([
                'data.email' => 'Sorry, your account is not yet active. Please contact the administrator.',
            ]);
        }

        if ($user && $user->is_locked) {
            throw ValidationException::withMessages([
                'data.email' => 'Your account is locked, please contact your system administrator',
            ]);
        }

        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        if (! Filament::auth()->attempt($this->getCredentialsFromFormData($data), $data['remember'] ?? false)) {
            $this->throwFailureValidationException();
        }

        $sessionUser = Filament::auth()->user();

        if (
            ($sessionUser instanceof FilamentUser) &&
            (! $sessionUser->canAccessPanel(Filament::getCurrentPanel()))
        ) {
            Filament::auth()->logout();

            $this->throwFailureValidationException();
        }

        session()->regenerate();

        session([
            'department_id' => $sessionUser->department_id,
            'section_id' => $sessionUser->section_id,
        ]);

        return app(LoginResponse::class);
    }
}
