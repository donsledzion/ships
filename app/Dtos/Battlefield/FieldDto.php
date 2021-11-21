<?php

namespace App\Dtos\Battlefield;

class FieldDto
{
    private $field;

    private $four_master;
    private $three_master;
    private $two_master;
    private $one_master;


    public function __construct($input_fields)
    {
        $this->field = json_decode($this->field,TRUE);
    }

    public function getField(string $column,string $row){
        return $this->field[$column][$row];
    }

    public function markAsSunk(ShipDto $ship){

    }

}
