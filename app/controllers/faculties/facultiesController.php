<?php

namespace App\Controllers\Faculties;
use App\Controllers\General\ResponseController;
use App\Models\Faculties;

class FacultiesController{
    public static function getAllFaculties(){
        ResponseController::sentSuccessflyResponse(Faculties::getFaculties(null));
    }

    public static function getFaculty(){
        ResponseController::sentSuccessflyResponse(Faculties::getFaculties('id'));
    }
}