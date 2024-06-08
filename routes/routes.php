<?php

namespace App\Routes;
use App\Services\Router;
use App\Controllers\Users\UserController;

class Routes
{
    public function __construct(){
        $this->routeUsers();
    }

    public function routeUsers(){
        Router::get('users', [UserController::class, 'getAllUsers']);
        Router::get('user', [UserController::class, 'getUserById']);
        Router::get('user_by_name', [UserController::class, 'getUserByName']);
        Router::post('users', [UserController::class, 'insertUser']);
        Router::put('users', [UserController::class, 'updateUser']);
        Router::delete('users', [UserController::class, 'deleteUser']);
    }
}
