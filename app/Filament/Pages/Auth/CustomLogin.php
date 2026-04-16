<?php

namespace App\Filament\Pages\Auth;

use App\Models\User;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;

class CustomLogin extends BaseLogin
{
    public function authenticate(): ?LoginResponse
    {
        $data = $this->form->getState();

        // 1. Cek apakah user terkunci sebelum memanggil fitur rate limiter
        $user = User::where('email', $data['email'])->first();
        if ($user && !$user->is_active) {
            throw ValidationException::withMessages([
                'data.email' => 'Sorry, your account is not yet active. Please contact the administrator.'
            ]);
            // Notification::make()
            //     ->title('Access Denied')
            //     ->body('Your account is not active yet, please contact your administrator')
            //     ->danger()
            //     ->persistent()
            //     ->send();
        }

        if ($user && $user->is_locked) {
            throw ValidationException::withMessages([
                'data.email' => 'Your account is locked, please contact your system administrator'
            ]);
            // Notification::make()
            //     ->title('Access Denied')
            //     ->body('Your account is locked, please contact your system administrator')
            //     ->danger()
            //     ->persistent()
            //     ->send();

            // Melempar pesan error validasi juga berfungsi untuk benar-benar menghentikan flow
            // throw \Illuminate\Validation\ValidationException::withMessages([
            //     'data.email' => 'Your account is locked, please contact your system administrator.',
            // ]);
        }

        // 2. Logic authentication bawaan Filament dipanggil setelahnya
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

        return app(LoginResponse::class);
    }
}
