<?php

namespace App\Controllers\Users;

use App\Controllers\General\ResponseController;
use App\Models\Student;

class StudentController
{
    public static function getAllStudents(){
        $data = Student::getStudent(null);
        ResponseController::sentSuccessflyResponse($data);
    }

    public static function getStudentById(){
        $data = Student::getStudent('id');
        ResponseController::sentSuccessflyResponse($data);
    }

    public static function getStudentByCode(){
        $data = Student::getStudent('code');
        ResponseController::sentSuccessflyResponse($data);
    }

    public static function getStudentByUserId(){
        $data = Student::getStudent('user_id');
        ResponseController::sentSuccessflyResponse($data);
    }

    public static function insertStudent(){
        $data = Student::insertStudent(null);
        ResponseController::sentSuccessflyResponse($data);    
    }

    public static function updateStudent(){
        $data = Student::updateStudent(null);
        ResponseController::sentSuccessflyResponse($data);
    }

    public static function deleteStudent(){
        $data = Student::deleteUser();
        ResponseController::sentSuccessflyResponse($data);
    }
}