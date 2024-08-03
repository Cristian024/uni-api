<?php

namespace App\Controllers\General;

use App\Controllers\General\ResponseController;
use Config\Credentials;

class ServerController {
    public static $methodsAllowed = ['GET', 'POST', 'DELETE', 'PUT'];

    public static function validateCorrectPetition(){
        Credentials::useProduction(true);
        ServerController::validateToken();
        ServerController::validateMethod();
        ServerController::validateRoute();
    }

    public static function validateToken(){
        $headers = getallheaders();
        if($headers === null || $headers === '') ResponseController::sentBadRequestResponse('Headers not provided');
        if(!isset($headers['access-token']) && !isset($headers['access-token'])) ResponseController::sentBadRequestResponse('Access token not provided');
        if($headers['access-token'] != Credentials::$ACCESS_TOKEN) ResponseController::sentUnauthorizedResponse('Incorrect Token');
    }

    public static function validateMethod(){
        $method = $_SERVER['REQUEST_METHOD'];
        if(!in_array($method, ServerController::$methodsAllowed)) ResponseController::sentMethodNotAllowedResponse();
    }

    public static function validateRoute(){
        parse_str($_SERVER['QUERY_STRING'], $params);
        if(!isset($params['route'])) ResponseController::sentMissingParamasResponse('Route not specified');
    }
}