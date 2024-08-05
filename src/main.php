<?php

require_once __DIR__ . '/config/imports.php';

use App\Controllers\General\ResponseController;
use App\Controllers\General\ServerController;
use App\Routes\Routes;
use App\Services\Router;

function main($event)
{
    ob_start();

    try {
        ServerController::validateCorrectPetition($event);

        $params = $event['queryStringParameters'];
        $method = $event['requestContext']['http']['method'];

        new Routes();
        Router::dispatch($method, $params['route']);
        
    } catch (\BadMethodCallException $e) {
        ResponseController::sentBadRequestResponse($e->getMessage());
    } catch (\Exception $e){
        ResponseController::sentInternalErrorResponse($e->getMessage());
    }

    $result = ob_get_clean();
    return $result;
}




