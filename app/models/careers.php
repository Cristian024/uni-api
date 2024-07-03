<?php

namespace App\Models;
use App\Controllers\General\DataBaseController;

class Careers{
    public $id;
    public $name;
    public $faculty;
    
    public function __construct($id, $name, $faculty){
        $this->id = $id;
        $this->name = $name;
        $this->faculty = $faculty;        
    }

    public static function getCareers($field){
        $sql = "SELECT * FROM careers";
        return DataBaseController::executeConsult($sql, $field);
    }


}