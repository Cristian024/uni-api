<?php

namespace App\Controllers\Users;
use App\Controllers\General\ResponseController;
use App\Helpers\RequestHelper;
use App\Models\Enterprises;

class EnterpriseController{
    public static function getAllEnterprises(){
        ResponseController::sentSuccessflyResponse(
            Enterprises::_consult()->_all()->_cmsel()->_init()
        );
    }

    public static function getEnterprise(){
        ResponseController::sentSuccessflyResponse(
            Enterprises::_consult()->_all()->_cmsel()->_id(RequestHelper::getIdParam())->_init()
        );
    }

    public static function getEnterpriseByUserId(){
        ResponseController::sentSuccessflyResponse(
            Enterprises::_consult()->_all()->_cmsel()->_row('user_id', RequestHelper::getIdParam())->_init()
        );
    }

    public static function insertEnterprise(){
        ResponseController::sentSuccessflyResponse(
            Enterprises::_insert(null)->_init()
        );
    }

    public static function updateEnterprise(){
        ResponseController::sentSuccessflyResponse(
            Enterprises::_update()->_id(RequestHelper::getIdParam())->_init()
        );
    }
}