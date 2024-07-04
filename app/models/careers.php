<?php

namespace App\Models;
use App\Controllers\General\DataBaseController;
use App\Helpers\DatabaseHelper;

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

    public static function test($field){
        $sql = DatabaseHelper::createFilterRows("careers", "ca")->_rows("ca.*, faculties.name AS 'f_name'")->_cmsel()->_injoin("faculty", "id", "faculties")->getSql();
        return DataBaseController::executeConsult($sql, $field);
    }
}