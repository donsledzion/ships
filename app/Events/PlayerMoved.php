<?php

namespace App\Events;

use App\Models\Board;
use App\Models\Table;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlayerMoved implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $log;
    public $table;
    public $column;
    public $row;
    public $result;
    public $board_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message,Board $board, string $column, int $row, string $result, string $log)
    {
        $this->message = $message;
        $this->log = $log;
        $this->table = $board->table;
        $this->column = $column;
        $this->row = $row;
        $this->result = $result;
        $this->board_id = $board->id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('game.'.$this->table->id);
    }

    public function broadcastWith()
    {
        $winner = null ;
        $table = Table::find($this->table->id);
        if($table->winner){
            $winner = User::find($table->winner)->name;
        }
        return [
                'table' => $table,
                'winner' => $winner,
                'message' => $this->message,
                'log' => $this->log,
                'shot_field' => [
                    'board' => $this->board_id,
                    'x' => $this->column,
                    'y' => $this->row,
                    'result' => $this->result,
                ]
            ];
    }
}
