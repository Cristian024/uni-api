<?php

namespace App\Models;
use App\Controllers\General\DataBaseController;

class Faculties{
    public $id;
    public $name;

    function __construct($id, $name){
        $this->id = $id;
        $this->name = $name;
    }

    public static function getFaculties($field){
        $sql = "SELECT * FROM faculties";
        return DataBaseController::executeConsult($sql, $field);
    }

    public static function insertFaculty($data){
        return DataBaseController::executeInsert('faculties', Faculties::class, $data);
    }
}