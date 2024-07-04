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
        $sql = DatabaseHelper::createFilterRows("careers", "c")->_all()->_cmsel()->getSql();
        return DataBaseController::executeConsult($sql, $field);
    }

    public static function test($field){
        $sql = DatabaseHelper::createFilterRows("users", "u")->_all()->_cmsel()->getSql();
        $sql = DatabaseHelper::createFilterCondition($sql)->_greq("register_date", "2024-07-01 06:43:00")
        ->_and()->_eq("id", "41")->getSql();
        return DataBaseController::executeConsult($sql, $field);
    }
}