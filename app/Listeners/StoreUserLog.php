<?php

namespace App\Listeners;

use App\Events\UserLogged;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;

class StoreUserLog
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserLogged  $event
     * @return void
     */
    public function handle(UserLogged $event)
    {
        UserLog::create([
            'user_id' => $event->user->id,
            'type' => $event->type
        ]);

        // $message = now() . " {$event->request->user()->name} telah {$event->type} pada aplikasi ini";
        // Storage::append('public/userLogs.log', $message);
    }
}
