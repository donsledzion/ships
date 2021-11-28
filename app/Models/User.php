<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'ranking',
        'email',
        'password',
        'last_activity',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [

        'last_activity' => 'datetime',
        'email_verified_at' => 'datetime',
    ];

    public function boards():hasMany
    {
        return $this->hasMany(Board::class);
    }

    public function getOnlineAttribute(){
        if($this->last_activity){
            $now = Carbon::createFromFormat('Y-m-d H:s:i',now());
            $last_seen = Carbon::createFromFormat('Y-m-d H:s:i',$this->last_activity);
            /*$last_seen = $this->last_activity;*/
            $difference = $now->diffInMinutes($last_seen);
            return $difference;
        } else {
            return null;
        }
    }

    public function setLastActivity($last_activity){
        $this->last_activity = $last_activity;
        $this->save();
    }

    public function onlineStatus(){
        $color = 'red';
        $interval = $this->online;
        if($interval) {
            if ($interval < 30) {
                $color = 'green';
            } else if ($interval < 60) {
                $color = 'yellow';
            } else if ($interval < 180) {
                $color = 'orange';
            }
        }


        return [
            'message' => $this->name.' o ID = '.$this->id.', ostatnio widziany (w sekundach): '. $this->online,
            'interval' => $this->online,
            'user_id' => $this->id,
            'color' => $color,
        ];

    }
}
