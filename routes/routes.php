<?php

namespace App\Routes;

use App\Services\Router;
use App\Controllers\Users\UserController;
use App\Controllers\Session\SessionController;

class Routes
{
    public function __construct()
    {
        $this->routeUsers();
        $this->routeSessions();
    }

    public function routeUsers()
    {
        Router::get('users', [UserController::class, 'getAllUsers']);
        Router::get('user', [UserController::class, 'getUserById']);
        Router::get('user_by_name', [UserController::class, 'getUserByName']);
        Router::post('users', [UserController::class, 'insertUser']);
        Router::put('users', [UserController::class, 'updateUser']);
        Router::delete('users', [UserController::class, 'deleteUser']);
        Router::post('login', [UserController::class, 'userLogin']);
        Router::post('register', [UserController::class, 'userRegister']);
    }

    public function routeSessions()
    {
        Router::get('sessions', [SessionController::class, 'getAllSessions']);
        Router::get('session', [SessionController::class, 'getSessionById']);
        Router::get('session', [SessionController::class, 'getSessionByUserId']);
        Router::post('validateSession', [SessionController::class, 'validateSession']);
    }
}
