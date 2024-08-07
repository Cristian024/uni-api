<?php

namespace App\Routes;

use App\Controllers\Chat\ConversationsController;
use App\Controllers\Chat\MessagesController;
use App\Controllers\Faculties\CareersController;
use App\Controllers\Faculties\FacultiesController;
use App\Controllers\Users\EnterpriseController;
use App\Controllers\Users\studentController;
use App\Services\Router;
use App\Controllers\Users\UserController;
use App\Controllers\Session\SessionController;
use App\Controllers\Users\ContactsController;

class Routes
{
    public function __construct()
    {
        $this->routeUsers();
        $this->routeSessions();
        $this->routeStudents();
        $this->routesFaculties();
        $this->routesCareers();
        $this->routeEnterprises();
        $this->routeContacts();
        $this->routeConversations();
        $this->routeMessages();
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
        Router::post('logout', [UserController::class, 'userLogout']);
        Router::get('any_by_user_id', [UserController::class, 'getUserByAnyType']);
    }

    public function routeContacts()
    {
        Router::get('contacts_by_user_id', [ContactsController::class, 'getContactsByUserId']);
        Router::put('contacts', [ContactsController::class, 'updateContacts']);
    }

    public function routeSessions()
    {
        Router::get('sessions', [SessionController::class, 'getAllSessions']);
        Router::get('session', [SessionController::class, 'getSessionById']);
        Router::get('session', [SessionController::class, 'getSessionByUserId']);
        Router::post('validateSessionStudent', [SessionController::class, 'validateSessionStudent']);
        Router::post('validateSessionEnterprise', [SessionController::class, 'validateSessionEnterprise']);
        Router::post('validateSessionAny', [SessionController::class, 'validateSessionAny']);
    }

    public function routeStudents()
    {
        Router::get('students', [StudentController::class, 'getAllStudents']);
        Router::get('student', [StudentController::class, 'getStudentById']);
        Router::get('student_by_code', [StudentController::class, 'getStudentByCode']);
        Router::get('student_by_user_id', [StudentController::class, 'getStudentByUserId']);
        Router::put('student', [studentController::class, 'updateStudent']);
    }

    public function routesFaculties()
    {
        Router::get('faculties', [FacultiesController::class, 'getAllFaculties']);
        Router::get('faculty', [FacultiesController::class, 'getFaculty']);
    }

    public function routesCareers()
    {
        Router::get('careers', [CareersController::class, 'getAllCareers']);
        Router::get('career', [CareersController::class, 'getCareerById']);
        Router::get('career_by_faculty', [CareersController::class, 'getCareerByFacultyId']);
        Router::post('careers', [CareersController::class, 'insertCareer']);
        Router::delete('career', [CareersController::class, 'deleteCareer']);
    }

    public function routeEnterprises()
    {
        Router::get("enterprises", [EnterpriseController::class, "getAllEnterprises"]);
        Router::get("enterprise", [EnterpriseController::class, "getEnterprise"]);
        Router::get("enterprise_by_user_id", [EnterpriseController::class, "getEnterpriseByUserId"]);
        Router::put("enterprise", [EnterpriseController::class, "updateEnterprise"]);
    }

    public function routeConversations(){
        Router::get('conversation', [ConversationsController::class, 'getConversationById']);
        Router::post('conversation_by_users', [ConversationsController::class, 'getConversationByUsers']);
        Router::put('conversation', [ConversationsController::class, 'updateConversation']);
    }

    public function routeMessages(){
        Router::post('message_by_conversation', [MessagesController::class, 'getMessagesByConversationId']);
        Router::post('message', [MessagesController::class, 'insertMessage']);
        Router::put('messages_state_list', [MessagesController::class, 'updateMessageStateList']);
    }
}
