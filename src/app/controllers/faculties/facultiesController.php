<?php

namespace App\Controllers\Faculties;
use App\Controllers\General\ResponseController;
use App\Helpers\RequestHelper;
use App\Models\Faculties;

class FacultiesController{
    public static function getAllFaculties(){
        ResponseController::sentSuccessflyResponse(
            Faculties::_consult()->_all()->_cmsel()->_init()
        );
    }

    public static function getFaculty(){
        ResponseController::sentSuccessflyResponse(
            Faculties::_consult()->_all()->_cmsel()->_id(RequestHelper::getIdParam())->_init()
        );
    }
}