<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Board extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'table_id',
        'initialized',
    ] ;

    protected $hidden = [
        'fields',
    ];

    protected $casts = [
        'initialized' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];



    public function user():belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function table():belongsTo
    {
        return $this->belongsTo(Table::class);
    }

    public function getCell(string $column, int $row)
    {
        if(($column<'A')||($column>'J')||($row<1)||($row>10)){
            return false;
        }
        error_log("Pobieram pole: ".json_decode($this->fields,TRUE)[$column][$row]);
        return json_decode($this->fields,TRUE)[$column][$row];
    }

    public function setCell(string $column, int $row, string $value)
    {
        $fields = json_decode($this->fields,TRUE) ;
        $fields[$column][$row] = $value ;
        $this->fields = json_encode($fields);
        $this->save();
    }

    public function getFieldssAttribute(){
        if(Auth::id()==$this->user->id){
            return $this->fields;
        } else {
            return str_replace('@','x',$this->fields);
        }
    }

    static public function freshField(){
        return json_encode([
            'A' => [
                '1' => 'x',
                '2' => 'x',
                '3' => 'x',
                '4' => 'x',
                '5' => 'x',
                '6' => 'x',
                '7' => 'x',
                '8' => 'x',
                '9' => 'x',
                '10' => 'x',
            ],
            'B' => [
                '1' => 'x',
                '2' => 'x',
                '3' => 'x',
                '4' => 'x',
                '5' => 'x',
                '6' => 'x',
                '7' => 'x',
                '8' => 'x',
                '9' => 'x',
                '10' => 'x',
            ],
            'C' => [
                '1' => 'x',
                '2' => 'x',
                '3' => 'x',
                '4' => 'x',
                '5' => 'x',
                '6' => 'x',
                '7' => 'x',
                '8' => 'x',
                '9' => 'x',
                '10' => 'x',
            ],
            'D' => [
                '1' => 'x',
                '2' => 'x',
                '3' => 'x',
                '4' => 'x',
                '5' => 'x',
                '6' => 'x',
                '7' => 'x',
                '8' => 'x',
                '9' => 'x',
                '10' => 'x',
            ],
            'E' => [
                '1' => 'x',
                '2' => 'x',
                '3' => 'x',
                '4' => 'x',
                '5' => 'x',
                '6' => 'x',
                '7' => 'x',
                '8' => 'x',
                '9' => 'x',
                '10' => 'x',
            ],
            'F' => [
                '1' => 'x',
                '2' => 'x',
                '3' => 'x',
                '4' => 'x',
                '5' => 'x',
                '6' => 'x',
                '7' => 'x',
                '8' => 'x',
                '9' => 'x',
                '10' => 'x',
            ],
            'G' => [
                '1' => 'x',
                '2' => 'x',
                '3' => 'x',
                '4' => 'x',
                '5' => 'x',
                '6' => 'x',
                '7' => 'x',
                '8' => 'x',
                '9' => 'x',
                '10' => 'x',
            ],
            'H' => [
                '1' => 'x',
                '2' => 'x',
                '3' => 'x',
                '4' => 'x',
                '5' => 'x',
                '6' => 'x',
                '7' => 'x',
                '8' => 'x',
                '9' => 'x',
                '10' => 'x',
            ],
            'I' => [
                '1' => 'x',
                '2' => 'x',
                '3' => 'x',
                '4' => 'x',
                '5' => 'x',
                '6' => 'x',
                '7' => 'x',
                '8' => 'x',
                '9' => 'x',
                '10' => 'x',
            ],
            'J' => [
                '1' => 'x',
                '2' => 'x',
                '3' => 'x',
                '4' => 'x',
                '5' => 'x',
                '6' => 'x',
                '7' => 'x',
                '8' => 'x',
                '9' => 'x',
                '10' => 'x',
            ],

        ]);
    }

    public function checkIfSunk(string $column, int $row)
    {
        $column = ord($column);

        if((($this->getCell(chr($column-1),$row) == '@')||($this->checkIfSunk(chr($column-1),$row)))
        ||(($this->getCell(chr($column+1),$row) == '@')||($this->checkIfSunk(chr($column+1),$row)))
        ||(($this->getCell($column,$row-1) == '@')||($this->checkIfSunk($column,$row-1)))
        ||(($this->getCell($column,$row+1) == '@')||($this->checkIfSunk($column,$row)+1))
        ){
            return false;
        }
        return true;
    }

}
