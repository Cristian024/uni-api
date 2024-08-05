<?php

namespace App\Controllers\Faculties;

use App\Controllers\General\ResponseController;
use App\Helpers\RequestHelper;
use App\Models\Careers;

class CareersController extends ResponseController
{
    public static function getAllCareers()
    {
        CareersController::sentSuccessflyResponse(
            Careers::_consult()->_all()->_cmsel()->_init()
        );
       
    }

    public static function getCareerById()
    {
        CareersController::sentSuccessflyResponse(
            Careers::_consult()->_all()->_cmsel()->_id(RequestHelper::getIdParam())->_init()
        );
    }

    public static function getCareerByFacultyId()
    {
        CareersController::sentSuccessflyResponse(
            Careers::_consult()->_all()->_cmsel()->_row('faculty', RequestHelper::getIdParam())->_init()
        );
    }

    public static function insertCareer(){
        CareersController::sentSuccessflyResponse(
            Careers::_insert(null)->_init()
        );
    }

    public static function deleteCareer(){
        CareersController::sentSuccessflyResponse(
            Careers::_delete()->_id(RequestHelper::getIdParam())->_init()
        );
    }
}