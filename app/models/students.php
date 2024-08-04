<?php

namespace App\Models;

class Students extends Model
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
}