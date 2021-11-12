<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Table extends Model
{
    use HasFactory;

    protected $fillable  = [
        'completed',
        'winner',
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

    public function board1():Board
    {
        return Board::where('table_id',$this->id)->orderBy('id','asc')->first();
    }
    public function board2():Board
    {
        return Board::where('table_id',$this->id)->orderBy('id','desc')->first();
    }
    /*public function getPlayer1Attribute(){
        $board1 = $this->boards->orderBy('id','asc')->first();

    }*/
}
