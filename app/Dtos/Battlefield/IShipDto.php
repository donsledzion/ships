<?php

namespace App\Dtos\Battlefield;

interface IShipDto
{

    public function __construct(array $sections);

    public function validateIntegrity();

    public function getSections();

    public function getSize();

}
