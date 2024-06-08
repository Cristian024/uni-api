<?php

namespace App\Models;

use App\Controllers\General\DataBaseController;

class User
{
    public $id;
    public $name;
    public $age;

    public static function getUsers($field){
        $sql = "SELECT * FROM users"; 
        return DataBaseController::executeConsult($sql, $field);
    }

    public static function insertUser(){
        return DataBaseController::executeInsert('users', User::class); 
    }

    public static function updateUser(){
        return DataBaseController::executeUpdate('users', User::class);
    }

    public static function deleteUser(){
        return DataBaseController::executeDelete('users');
    }
}
