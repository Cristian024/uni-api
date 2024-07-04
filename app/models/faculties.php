<?php

namespace App\Models;
use App\Controllers\General\DataBaseController;
use App\Helpers\DatabaseHelper;

class Faculties{
    public $id;
    public $name;

    function __construct($id, $name){
        $this->id = $id;
        $this->name = $name;
    }

    public static function getFaculties($filter){
        $sql = DatabaseHelper::createFilterRows("faculties", "f")->_all()->_cmsel()->addFilter($filter);
        return DataBaseController::executeConsult($sql);
    }

    public static function insertFaculty($data){
        return DataBaseController::executeInsert('faculties', Faculties::class, $data);
    }
}