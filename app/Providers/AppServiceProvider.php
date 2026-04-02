<?php

namespace App\Providers;

use App\Listeners\HandleUserLoginAttempts;
use Filament\Notifications\Notification;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Filament\Notifications\Livewire\Notifications;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\VerticalAlignment;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Notifications::alignment(Alignment::Right);
        Notifications::verticalAlignment(VerticalAlignment::End);
        Event::listen(Failed::class, HandleUserLoginAttempts::class);
        Event::listen(Login::class, HandleUserLoginAttempts::class);
    }
}
