<?php

namespace App\Models;

use App\Controllers\General\DataBaseController;
use App\Controllers\General\ResponseController;
use App\Helpers\DatabaseHelper;
use App\Helpers\RequestHelper;
use App\Models\Session;

class Student
{
    public $id;
    public $first_name;
    public $last_name;
    public $cellphone;
    public $date_of_birth;
    public $gender;
    public $code;
    public $career;
    public $faculty;
    public $semester;
    public $user_id;

    function __construct($id,$firts_name, $last_name,$cellphone, $date_of_birth, $gender, $code, $career, $faculty, $semester, $user_id)
    {
        $this->id = $id;
        $this->first_name = $firts_name;
        $this->last_name = $last_name;
        $this->cellphone = $cellphone;
        $this->date_of_birth = $date_of_birth;
        $this->gender = $gender;
        $this->code = $code;
        $this->career = $career;
        $this->faculty = $faculty;
        $this->semester = $semester;
        $this->user_id = $user_id;
    }

    public static function getStudent($field)
    {
        $sql = "SELECT s.*, u.email FROM students AS s
        INNER JOIN users AS u ON s.user_id = u.id";
        return DataBaseController::executeConsult($sql, $field);
    }

    public static function insertStudent($data)
    {
        return DataBaseController::executeInsert('students', Student::class, $data);
    }

    public static function updateStudent($data)
    {
        return DataBaseController::executeUpdate('students', Student::class, $data);
    }

    public static function deleteUser()
    {
        return DataBaseController::executeDelete('students', 'id');
    }
}