<?php

namespace App\Controllers\Users;

use App\Controllers\General\ResponseController;
use App\Helpers\RequestHelper;
use App\Models\User;

class UserController{
    public static function getAllUsers(){
        $data = User::getUsers(null);
        ResponseController::sentSuccessflyResponse($data);
    }

    public static function getUserById(){
        $data = User::getUsers('id');
        ResponseController::sentSuccessflyResponse($data);
    }

    public static function insertUser(){
        $data = User::insertUser(null);
        ResponseController::sentSuccessflyResponse($data);    
    }

    public static function updateUser(){
        $data = User::updateUser(null);
        ResponseController::sentSuccessflyResponse($data);
    }

    public static function deleteUser(){
        $data = User::deleteUser();
        ResponseController::sentSuccessflyResponse($data);
    }

    public static function userLogin(){
        $data = User::userLogin();
        ResponseController::sentSuccessflyResponse($data);
    }

    public static function userRegister(){
        $data = User::userRegister();
        ResponseController::sentSuccessflyResponse($data);
    }
}