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

    public static function getCareers($filter){
        $sql = DatabaseHelper::createFilterRows("careers", "c")->_all()->_cmsel()->addFilter($filter);
        return DataBaseController::executeConsult($sql);
    }
}