<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Board;
use Illuminate\Support\Facades\Auth;

class Table extends Model
{
    use HasFactory;

    protected $fillable  = [
        'completed',
        'winner',
        'current_player',
    ] ;

    protected $casts =  [
        'completed' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function boards():hasMany
    {
        return $this->hasMany(Board::class);
    }

    public function board1()
    {
        return Board::where('table_id',$this->id)->orderBy('id','asc')->first();
    }
    public function board2()
    {
        if($this->board1()) {
            return Board::where('table_id', $this->id)->where('id', '<>', $this->board1()->id)->orderBy('id', 'desc')->first();
        }
        return null;
    }

    public function reportReady(){
        if($this->boards->count() > 1) {
            if (($this->board1()->initialized) && ($this->board2()->initialized)) {
                $this->current_player = $this->board1()->user->id;
                $this->save();
            }
        }
    }

    public function switchPlayers(){
        if($this->current_player==$this->board1()->user->id){
            $this->current_player = $this->board2()->user->id;
        } else {
            $this->current_player = $this->board1()->user->id;
        }
        $this->save();
        return $this->current_player;
    }

    public function setCompleted(){
        $this->completed = true;
        $this->save();
    }

    public function scorePoints(){
        $winner_id = $this->winner;
        if($winner_id) {
            $player1 = $this->board1()->user;
            $player2 = $this->board2()->user;

            if($winner_id == $player1->id) {
                $winner = $player1;
                $looser = $player2;
            } else {
                $winner = $player2;
                $looser = $player1;
            }
        $rank_diff = abs($winner->ranking - $looser->ranking);
        $prize = (int)($rank_diff + $looser->ranking*0.02) ;

        $winner->updateRanking($prize);
        $looser->updateRanking((-1)*$prize);


        } else {
            return response()->json([
                'status' => 'fail',
                'message' => _('errors.no_winner')
            ]);
        }
    }

    public function setWinner($id){
        $this->winner = $id;
        $this->save();
    }

    public function isCompleted():bool{
        return $this->completed;
    }

    public function getWinner()
    {
        return User::find($this->winner);
    }

    public function getCurrentPlayer()
    {
        return User::find($this->current_player);
    }

    public function hasStarted(){
        return ((!$this->board1()->initialized)&&($this->board2()->initialized));
    }

    public function idle(){
        return Carbon::now()->diffInMinutes(Carbon::createFromFormat('Y-m-d H:i:s',$this->updated_at));
    }

    public function getStatusAttribute(){
        if($this->winner){
            return [
                'status' => __('games.status.finished'),
                'picture' => 'winner',
            ];
        } else if(!$this->current_player){
            return [
                'status' => __('games.status.preparations'),
                'picture' => 'prepare',
            ];
        } else {
            return [
                'status' => __('games.status.fight'),
                'picture' => 'fight',
            ];
        }
    }
}
