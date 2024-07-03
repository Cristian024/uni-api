<?php

namespace App\Controllers\Faculties;
use App\Controllers\General\ResponseController;
use App\Models\Careers;

class CareersController{
    public static function getAllCareers(){
        ResponseController::sentSuccessflyResponse(Careers::getCareers(null));
    }

    public static function getCareerById(){
        ResponseController::sentSuccessflyResponse(Careers::getCareers('id'));
    }

    public static function getCareerByFacultyId(){
        ResponseController::sentSuccessflyResponse(Careers::getCareers('faculty'));
    }
}