<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AssignTask implements ShouldBroadcast
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
    public function __construct($task_name, $project_name, $user_id, $notification_id)
    {
        $this->message  = "You were assigned to the task {$task_name} from project {$project_name}";
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
        return ['notifications-assignTasks'];
    }

    public function broadcastAs() {
        return "event-assignTask-{$this->user_id}";
    }
}