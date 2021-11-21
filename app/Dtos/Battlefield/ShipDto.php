<?php

namespace App\Dtos\Battlefield;

class ShipDto implements IShipDto
{

    private $sections;
    private $size;

    public function __construct(array $sections)
    {
        $this->sections = [];
        foreach ($sections as $key => $value) {
            array_push($this->sections,['x' => ord($value['x'])-64, 'y' => $value['y']]);
        }
        $this->size = count($sections);
    }

    public function validateIntegrity():bool
    {
        foreach ($this->sections as $section){
            if(!$this->validateSingleField($section)){
                return false;
            }
        }
        switch ($this->size)
        {
            case 1:
                return $this->validateOneMaster();
            case 2:
                return $this->validateTwoMaster();
            case 3:
                return $this->validateThreeMaster();
            case 4:
                return $this->validateFourMaster();
            default: return false;
        }
    }

    public function getSections()
    {
        return $this->sections;
    }

    public function getSize():int
    {
        return $this->size;
    }

    private static function stickToEachOther(array $field_A, array $field_B):bool
    {
        $dist_x = abs($field_A['x'] - $field_B['x']);
        $dist_y = abs($field_A['y'] - $field_B['y']);
        if(($dist_x == 1)||($dist_y == 1)){
            if(($dist_x == 0)||($dist_y == 0)){
                return true;
            }
        }
        return false;
    }

    private function validateSingleField(array $field):bool
    {
        if($field['x'] < 1){
            return false;
        }
        if($field['x'] > 10){
            return false;
        }
        if($field['y'] < 1){
            return false;
        }
        if($field['y'] > 10){
            return false;
        }
        return true;
    }

    private function validateOneMaster():bool
    {
        return $this->validateSingleField($this->sections[0]);
    }

    private function validateTwoMaster():bool
    {
        return $this->stickToEachOther($this->sections[0],$this->sections[1]);
    }

    private function validateThreeMaster():bool
    {
        $field_A = $this->sections[0];
        $field_B = $this->sections[1];
        $field_C = $this->sections[2];

        if(($this->stickToEachOther($field_A,$field_B)&&$this->stickToEachOther($field_A,$field_C))
        ||($this->stickToEachOther($field_B,$field_A)&&$this->stickToEachOther($field_B,$field_C))
        ||($this->stickToEachOther($field_C,$field_A)&&$this->stickToEachOther($field_C,$field_B))){
            return true;
        }
        return false;
    }

    private function validateFourMaster():bool
    {
        $fields_range = $this->getFieldsRange();
        if(($fields_range == [2,2])
        ||($fields_range == [3,2])
        ||($fields_range == [2,3])
        ||($fields_range == [4,1])
        ||($fields_range == [1,4])){
            return true;
        }
        return false;
    }

    private function getFieldsRange():array
    {
        $x_max = 0 ;
        $x_min = 11;
        $y_max = 0 ;
        $y_min = 11;

        foreach($this->sections as $section){
            if($section['x'] > $x_max){
                $x_max = $section['x'];
            }
            if($section['x'] < $x_min){
                $x_min = $section['x'];
            }
            if($section['y'] > $y_max){
                $y_max = $section['y'];
            }
            if($section['y'] < $y_min){
                $y_min = $section['y'];
            }
        }
        return [abs($x_max-$x_min)+1,abs($y_max-$y_min)+1];
    }

}
