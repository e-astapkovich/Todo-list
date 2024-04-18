<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\NoteCreated;
use App\Models\User;
use App\Notifications\NoteCreated as NoteCreatedNotification;

class SendNotification implements ShouldQueue
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
    public function handle(NoteCreated $event): void
    {
        $admins = User::where('is_admin', true)->get();
        Notification::send($admins, new NoteCreatedNotification());
    }
}
