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
        'fields',
    ] ;

    protected $hidden = [

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

    public function opponentsBoard():Board{
        return $this['table']->boards->where('user.id','<>',$this->user_id)->first();
    }

    public function getCell(string $column, int $row)
    {
        if(($column<'A')||($column>'J')||($row<1)||($row>10)){
            return false;
        }
        //error_log("Pobieram pole: ".json_decode($this->fields,TRUE)[$column][$row]);
        return json_decode($this->fields,TRUE)[$column][$row];
    }

    public function isCellShip(string $column, int $row):bool{
        if(($this->getCell($column,$row)=='@')||($this->getCell($column,$row)=='#')){
            return true;
        }
        return false;
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
        error_log("==============================================================================");
        error_log("======================== CHECK IF SUNK =======================================");
        error_log("==============================================================================");
        error_log("=======================BADANIE POLA [".$this->getCell($column,$row)."]========================");
        error_log("==============================================================================");
        // if the cell is sunk and has no neighbouring cells that mean this is sunk one master
        if(($this->getCell($column,$row) == '#')&&(count($this->getFieldNeighbours($column,$row)) == 0)){
            error_log("============================> ONE-MASTER SUNK!");
            $this->markFieldAsSunk($column,$row);
            return true;
        } else if(($this->getCell($column,$row) == '#')&&(count($this->getFieldNeighbours($column,$row)) == 1)){
            // if the cell is sunk and has only one neighbouring cell, we have to check if: (that means it can be two-, three-, or four-master. It's just edging section)
            $neighbour_first = $this->getFieldNeighbours($column,$row)[0] ;
            // ...if the cell has more than only one neighbouring cell.
            if((count($this->getFieldNeighbours($neighbour_first['x'],$neighbour_first['y']))==1)&&($this->getCell($neighbour_first['x'],$neighbour_first['y'])=='#')){
            //If not we're sure that we sunk two-master
                error_log("============================> TWO-MASTER SUNK!");
                $this->markFieldAsSunk($column,$row);
                $this->markFieldAsSunk($neighbour_first['x'],$neighbour_first['y']);
                return true;
            }
            if((count($this->getFieldNeighbours($neighbour_first['x'],$neighbour_first['y']))==2)&&($this->getCell($neighbour_first['x'],$neighbour_first['y'])=='#')) {
                // If it has two neighbouring cells we have to check if each has only one neighbouring cell (and it's sunk btw.
                // That means we are considering the middle section of three master
                $neighbours = $this->getFieldNeighbours($neighbour_first['x'], $neighbour_first['y']);

                foreach ($neighbours as $neighbour) {
                    error_log("neighbours count: ".count($neighbours));
                    error_log("neighbour field [".$neighbour['x'].",".$neighbour['y']."] = ".$this->getCell($neighbour['x'], $neighbour['y']));
                    if ($this->getCell($neighbour['x'], $neighbour['y']) == '@') {
                        return false; // If any of neighbouring cells isn't sunk the battleship is not either.
                    }
                    $countNeighbours = count($this->getFieldNeighbours($neighbour['x'], $neighbour['y']));
                    if($countNeighbours>1){
                        //return false;
                        // here we have to consider what if neighbouring cell has more neighbours
                        // if it has two, that means we have snake-four master or square four master
                        // if it has three, that means we have Hydra-four-master
                        if($countNeighbours == 2){
                            // that means we have snake-long-four-master
                            $neighbourNeighbours = $this->getFieldNeighbours($neighbour['x'],$neighbour['y']);
                            foreach ($neighbourNeighbours as $neighbourNeighbour){
                                if ($this->getCell($neighbourNeighbour['x'], $neighbourNeighbour['y']) == '@') {
                                    return false; // If any of neighbouring cells isn't sunk the battleship is not either.
                                }
                            }
                            $this->markFieldAndNeighboursAsSunk($neighbour_first['x'], $neighbour_first['y']);
                            foreach ($neighbourNeighbours as $neighbourNeighbour) {
                                $this->markFieldAndNeighboursAsSunk($neighbourNeighbour['x'], $neighbourNeighbour['y']);
                            }
                            error_log("============================> THREE-MASTER SUNK! (option A)");
                            return true;
                        }
                    }
                }
                $this->markFieldAndNeighboursAsSunk($neighbour_first['x'], $neighbour_first['y']);
                error_log("============================> THREE-MASTER SUNK! (option A)");
                return true;
            }
            if((count($this->getFieldNeighbours($neighbour_first['x'],$neighbour_first['y']))==3)&&($this->getCell($neighbour_first['x'],$neighbour_first['y'])=='#')) {
                $neighbours = $this->getFieldNeighbours($neighbour_first['x'],$neighbour_first['y']);
                foreach ($neighbours as $neighbour) {
                    if ($this->getCell($neighbour['x'], $neighbour['y']) == '@') {
                        return false; // If any of neighbouring cells isn't sunk the battleship is not either.
                    }
                }
                $this->markFieldAndNeighboursAsSunk($column,$row);
                error_log("============================> FOUR-MASTER SUNK! (option FIRST :) )");
            }
        } else if(($this->getCell($column,$row) == '#')&&(count($this->getFieldNeighbours($column,$row)) == 2)) { // case in which we hit middle-section of three or four-master
            $neighbours = $this->getFieldNeighbours($column,$row);
            $mustBeFourMaster = false;
            foreach ($neighbours as $neighbour) {
                if($this->getCell($neighbour['x'], $neighbour['y']) == '@') {
                    error_log("Neighbour [".$neighbour['x'].",".$neighbour['y']."] is [".$this->getCell($neighbour['x'], $neighbour['y'])."] => dyskfalifikacja");
                    return false; // If any of neighbouring cells isn't sunk the battleship is not either.
                } else {
                    error_log("Neighbour [".$neighbour['x'].",".$neighbour['y']."] is [".$this->getCell($neighbour['x'], $neighbour['y'])."]");
                }
                $neighbourNeighbours = $this->getFieldNeighbours($neighbour['x'],$neighbour['y']);
                if(count($neighbourNeighbours)>1){
                    $mustBeFourMaster = true;
                }
            }
            if(!$mustBeFourMaster) {
                $this->markFieldAndNeighboursAsSunk($column, $row);
                error_log("============================> THREE-MASTER SUNK! (option B)");
                return true;
            } else {
                foreach ($neighbours as $neighbour) {
                    $neighbourNeighbours = $this->getFieldNeighbours($neighbour['x'],$neighbour['y']);
                    foreach ($neighbourNeighbours as $neighbourNeighbour){
                        if($this->getCell($neighbourNeighbour['x'], $neighbourNeighbour['y']) == '@') {
                            return false;
                        }
                    }

                }
                foreach ($neighbours as $neighbour) {
                    $neighbourNeighbours = $this->getFieldNeighbours($neighbour['x'],$neighbour['y']);
                    foreach ($neighbourNeighbours as $neighbourNeighbour){
                        $this->markFieldAndNeighboursAsSunk($neighbourNeighbour['x'],$neighbourNeighbour['y']);
                    }

                }
                error_log("============================> FOUR-MASTER SUNK! (Option SECOND)");
                return true;
            }
        } else if(($this->getCell($column,$row) == '#')&&(count($this->getFieldNeighbours($column,$row)) == 3)) { // case in which we know that is four-master, but we have to check if all sections are sunk
            $neighbours = $this->getFieldNeighbours($column,$row);
            foreach ($neighbours as $neighbour) {
                if ($this->getCell($neighbour['x'], $neighbour['y']) == '@') {
                    return false; // If any of neighbouring cells isn't sunk the battleship is not either.
                }
            }
            $this->markFieldAndNeighboursAsSunk($column,$row);
            error_log("============================> FOUR-MASTER SUNK! (option LAST :) )");
        }
        return false;
    }

    public function markFieldAndNeighboursAsSunk(string $column, int $row){
        $neighbours = $this->getFieldNeighbours($column, $row);
        $this->markFieldAsSunk($column,$row);
        foreach ($neighbours as $neighbour){
            $this->markFieldAsSunk($neighbour['x'],$neighbour['y']);
        }
    }

    public function markFieldAsSunk(string $column, int $row){
        $prevCol = chr(ord($column)-1);
        $nextCol = chr(ord($column)+1);
        /**
         * First row
         * */
        $cell = $this->getCell($prevCol,$row-1) ;
        if($cell == 'x'){
            $this->setCell($prevCol,$row-1,'*');
        }
        $cell = $this->getCell($column,$row-1) ;
        if($cell == 'x'){
            $this->setCell($column,$row-1,'*');
        }
        $cell = $this->getCell($nextCol,$row-1) ;
        if($cell == 'x'){
            $this->setCell($nextCol,$row-1,'*');
        }
        /**
         * Second row
         * */
        $cell = $this->getCell($prevCol,$row) ;
        if($cell == 'x'){
            $this->setCell($prevCol,$row,'*');
        }

        $cell = $this->getCell($nextCol,$row) ;
        if($cell == 'x'){
            $this->setCell($nextCol,$row,'*');
        }
        /**
         * Third
         * */
        $cell = $this->getCell($prevCol,$row+1) ;
        if($cell == 'x'){
            $this->setCell($prevCol,$row+1,'*');
        }
        $cell = $this->getCell($column,$row+1) ;
        if($cell == 'x'){
            $this->setCell($column,$row+1,'*');
        }
        $cell = $this->getCell($nextCol,$row+1) ;
        if($cell == 'x'){
            $this->setCell($nextCol,$row+1,'*');
        }
    }

    public function getFieldNeighbours(string $column, int $row):array{
        $column = ord($column);

        $neighbours = [] ;
        if($this->isCellShip(chr($column-1),$row)){
            //error_log("Doliczam: [".chr($column-1).",".$row."]");
            array_push($neighbours,['x' => chr($column-1),'y' => $row]);
        }
        if($this->isCellShip(chr($column+1),$row)){
            //error_log("Doliczam: [".chr($column+1).",".$row."]");
            array_push($neighbours,['x' => chr($column+1),'y' => $row]);
        }
        if($this->isCellShip(chr($column),$row-1)){
            //error_log("Doliczam: [".chr($column).",".($row-1)."]");
            array_push($neighbours,['x' => chr($column),'y' => $row-1]);
        }
        if($this->isCellShip(chr($column),$row+1)){
            //error_log("Doliczam: [".chr($column).",".($row+1)."]");
            array_push($neighbours,['x' => chr($column),'y' => $row+1]);
        }
        //error_log("field [".chr($column).",".$row."] has ". count($neighbours). " neighbours.");
        return $neighbours;
    }

    public function checkIfCompleted():bool{
        for($col = 'A' ; $col <= 'J' ; $col++){
            for($row = 1 ; $row <= 10 ;$row++){
                if($this->getCell($col,$row)=='@'){
                    return false;
                }
            }
        }
        error_log("Board is completed - setting as completed");
        $table = Table::find($this['table']->id);
        $table->setCompleted();
        error_log("Board is completed - setting winner");
        $table->setWinner($this->opponentsBoard()->user->id);
        error_log("Board is completed - winner set - exiting model");
        return true;
    }

}
