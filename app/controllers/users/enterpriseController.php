<?php

namespace App\Controllers\Users;
use App\Controllers\General\ResponseController;
use App\Helpers\DatabaseHelper;
use App\Helpers\RequestHelper;
use App\Models\Enterprise;

class EnterpriseController{
    public static function getAllEnterprises(){
        ResponseController::sentSuccessflyResponse(Enterprise::getEnterprise(null));
    }

    public static function getEnterprise(){
        $id = RequestHelper::getIdParam();
        $filter = DatabaseHelper::createFilterCondition("")->_eq("id", $id);
        ResponseController::sentSuccessflyResponse(Enterprise::getEnterprise($filter));
    }

    public static function getEnterpriseByUserId(){
        $id = RequestHelper::getIdParam();
        $filter = DatabaseHelper::createFilterCondition("")->_eq("user_id", $id);
        ResponseController::sentSuccessflyResponse(Enterprise::getEnterprise($filter));
    }

    public static function insertEnterprise(){
        ResponseController::sentSuccessflyResponse(Enterprise::insertEnterprise(null));
    }
}