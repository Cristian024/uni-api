<?php

namespace App\Models;

class Faculties extends Model{
    public $id;
    public $name;

    function __construct($id, $name){
        $this->id = $id;
        $this->name = $name;
    }
}