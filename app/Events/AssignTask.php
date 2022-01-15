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

    public $task_name;

    public $message;

    public $project_id;

    public $task_id;

    public $user_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($task_name, $project_name, $task_id, $project_id, $user_id)
    {
        $this->task_name = $task_name;
        $this->message  = "You were assigned to the task {$task_name} from project {$project_name}";
        $this->task_id = $task_id;
        $this->project_id = $project_id;
        $this->user_id = $user_id;
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