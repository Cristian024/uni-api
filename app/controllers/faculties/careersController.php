<?php

namespace App\Controllers\Faculties;
use App\Controllers\General\ResponseController;
use App\Helpers\DatabaseHelper;
use App\Helpers\RequestHelper;
use App\Models\Careers;

class CareersController{
    public static function getAllCareers(){
        ResponseController::sentSuccessflyResponse(Careers::getCareers(null));
    }

    public static function getCareerById(){
        $filter = DatabaseHelper::createFilterCondition("")->_eq("id", RequestHelper::getIdParam());
        ResponseController::sentSuccessflyResponse(Careers::getCareers($filter));
    }

    public static function getCareerByFacultyId(){
        $filter = DatabaseHelper::createFilterCondition("")->_eq("faculty", RequestHelper::getIdParam())->getSql();
        ResponseController::sentSuccessflyResponse(Careers::getCareers($filter));
    }
}