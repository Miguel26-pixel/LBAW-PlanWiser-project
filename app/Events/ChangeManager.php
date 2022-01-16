<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChangeManager implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public $user_id;

    public $notification_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($project_name, $manager_name, $user_id, $notification_id)
    {
        $this->message  = "{$manager_name} is now manager of the project {$project_name}";
        $this->user_id = $user_id;
        $this->notification_id = $notification_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return ['notifications-changeManager'];
    }

    public function broadcastAs() {
        return "event-changeManager-{$this->user_id}";
    }
}