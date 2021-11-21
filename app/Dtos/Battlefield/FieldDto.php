<?php

namespace App\Dtos\Battlefield;

use App\Models\Board;

class FieldDto
{
    private $fields;

    private $ships;


    public function __construct(Board $board)
    {
        $this->fields = json_decode($board->fields,TRUE);



    }

    public function getField(string $column,string $row){
        return $this->fields[$column][$row];
    }

    public function markAsSunk(ShipDto $ship){

    }


}
