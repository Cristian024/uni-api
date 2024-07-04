<?php

namespace App\Controllers\Users;

use App\Controllers\General\ResponseController;
use App\Helpers\DatabaseHelper;
use App\Helpers\RequestHelper;
use App\Models\Student;

class StudentController
{
    public static function getAllStudents(){
        ResponseController::sentSuccessflyResponse(Student::getStudent(null));
    }

    public static function getStudentById(){
        $filter = DatabaseHelper::createFilterCondition("")->_eq("s.id", RequestHelper::getIdParam());
        ResponseController::sentSuccessflyResponse(Student::getStudent($filter));
    }

    public static function getStudentByCode(){
        $filter = DatabaseHelper::createFilterCondition("")->_eq("code", RequestHelper::getIdParam());
        ResponseController::sentSuccessflyResponse(Student::getStudent($filter));
    }

    public static function getStudentByUserId(){
        $filter = DatabaseHelper::createFilterCondition("")->_eq("user_id", RequestHelper::getIdParam());
        ResponseController::sentSuccessflyResponse(Student::getStudent($filter));
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