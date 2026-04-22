<?php

namespace App\Providers;

use App\Listeners\HandleUserLoginAttempts;
use Filament\Notifications\Livewire\Notifications;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\VerticalAlignment;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

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
        Event::listen(Authenticated::class, function ($event) {
            if (! Session::has('active_company')) {
                Session::put('active_company', $event->user->assign_company);
            }
        });
    }
}
