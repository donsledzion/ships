<?php

namespace App\Events;

use App\Models\Table;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $author;
    public $message;
    public $table;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $author, string $message, Table $table)
    {
        $this->author = $author;
        $this->message = $message;
        $this->table = $table;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('game.'.$this->table->id.'.chat');
    }

    public function broadcastWith()
    {
        return [
            'author' => $this->author,
            'message' => $this->message,
        ];
    }
}
