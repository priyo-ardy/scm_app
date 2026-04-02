<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Request;

class HandleUserLoginAttempts
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        if ($event instanceof Failed) {
            if ($event->user instanceof User) {
                $user = $event->user;

                $user->login_attempt = ($user->login_attempt ?? 0) + 1;

                if ($user->login_attempt >= 5) {
                    $user->is_locked = true;
                }

                $user->save();
            }
        }

        if ($event instanceof Login) {
            if ($event->user instanceof User) {
                $user = $event->user;

                $user->login_attempt = 0;
                $user->is_locked = false;
                $user->last_login = now();
                $user->last_login_from = Request::ip();

                $user->save();
            }
        }
    }
}
