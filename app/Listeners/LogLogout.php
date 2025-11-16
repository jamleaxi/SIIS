<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Request;
use Spatie\Activitylog\Models\Activity;

class LogLogout
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
    public function handle(Logout $event)
    {
        $user = $event->user;
        $userId = $user?->getAuthIdentifier(); // safer than $user->id

        Activity::create([
            'log_name' => 'auth',
            'description' => 'User logged out',
            'subject_type' => $user ? get_class($user) : null,
            'subject_id' => $userId,
            'causer_type' => $user ? get_class($user) : null,
            'causer_id' => $userId,
            'properties' => [
                'ip' => Request::ip(),
                'user_agent' => Request::userAgent(),
            ],
        ]);
    }
}
