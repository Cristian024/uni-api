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

    public static function getFaculties($field){
        $sql = DatabaseHelper::createFilterRows("faculties", "f")->_all()->_cmsel()->getSql();
        return DataBaseController::executeConsult($sql, $field);
    }

    public static function insertFaculty($data){
        return DataBaseController::executeInsert('faculties', Faculties::class, $data);
    }
}