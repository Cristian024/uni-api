<?php

namespace App\Routes;

use App\Controllers\Users\studentController;
use App\Services\Router;
use App\Controllers\Users\UserController;
use App\Controllers\Session\SessionController;

class Routes
{
    public function __construct()
    {
        $this->routeUsers();
        $this->routeSessions();
        $this->routeStudents();
    }

    public function routeUsers()
    {
        Router::get('users', [UserController::class, 'getAllUsers']);
        Router::get('user', [UserController::class, 'getUserById']);
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
        Router::post('validateSessionStudent', [SessionController::class, 'validateSessionStudent']);
        Router::post('validateSessionEnterprise', [SessionController::class, 'validateSessionEnterprise']);
    }

    public function routeStudents()
    {
        Router::get('students', [StudentController::class, 'getAllUsers']);
        Router::get('student', [StudentController::class, 'getStudentById']);
        Router::get('student_by_code', [StudentController::class, 'getStudentByCode']);
        Router::get('student_by_user_id', [StudentController::class, 'getStudentByUserId']);
        Router::put('student', [studentController::class, 'updateStudent']);
    }
}
