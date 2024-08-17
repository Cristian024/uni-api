<?php

require_once __DIR__ . '/config/imports.php';

use App\Controllers\General\ResponseController;
use App\Controllers\General\ServerController;
use App\Helpers\RequestHelper;
use App\Routes\Routes;
use App\Services\Router;

function main($event)
{
    ob_start();

    try {
        ServerController::validateCorrectPetition($event);

        new Routes();
        Router::dispatch(RequestHelper::$HTTP, RequestHelper::$ROUTE);
        
    } catch (\BadMethodCallException $e) {
        ResponseController::sentBadRequestResponse($e->getMessage());
    } catch (\UnexpectedValueException $e) {
        ResponseController::sentBadRequestResponse($e->getMessage());
    } catch (\PDOException $e) {
        ResponseController::sentDatabaseErrorResponse($e->getMessage());
    } catch (\Exception $e) {
        ResponseController::sentInternalErrorResponse($e->getMessage());
    }

    $result = ob_get_clean();
    return $result;
}




