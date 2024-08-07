<?php

namespace App\Controllers\General;

use App\Controllers\General\ResponseController;
use App\Helpers\RequestHelper;
use Config\Credentials;

class ServerController
{
    public static $methodsAllowed = ['GET', 'POST', 'DELETE', 'PUT'];

    public static function validateCorrectPetition($event)
    {
        try {
            Credentials::useProduction(false);
            ServerController::validateIncomingEvent($event);
            ServerController::validateToken($event);
            ServerController::validateMethod($event);
            ServerController::validateRoute($event);
        } catch (\BadMethodCallException $e) {
            throw new \BadMethodCallException($e->getMessage());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function getEvent()
    {
        return RequestHelper::$EVENT;
    }

    public static function validateIncomingEvent($event)
    {
        RequestHelper::$EVENT = $event;

        if (!isset($event['queryStringParameters'])) {
            throw new \BadMethodCallException("Query String parameters not provided ");
        } else {
            RequestHelper::$PARAMS = $event['queryStringParameters'];
        }

        if (!isset($event['requestContext'])) {
            throw new \BadMethodCallException("Request context not provided ");
        } else {
            $requestContext = $event['requestContext'];
            if (isset($requestContext['http'])) {
                RequestHelper::$HTTP = $requestContext['http'];
                if (!isset($requestContext['http']['method'])) {
                    throw new \BadMethodCallException("Request method not privided ");
                }
            }else{
                throw new \BadMethodCallException("Access HTTP info not provided ");
            }
        }

        if (!isset($event['headers'])) {
            throw new \BadMethodCallException("Headers not provided");
        } else {
            RequestHelper::$HEADERS = $event['headers'];
        }

        if (isset($event['body'])) {
            RequestHelper::$BODY = json_decode($event['body'], true);
        }

        if (isset($event['cookies'])) {
            RequestHelper::$COOKIES = $event['cookies'];
        }

        if (isset($event['rawPath'])) {
            $path = isset($event['rawPath']) ? $event['rawPath'] : '/';
            $idExplode = explode('/', $path);
            $queryId = ($path !== '/') ? end($idExplode) : null;
            RequestHelper::$QUERYID = $queryId;
        }
    }

    public static function validateToken($event)
    {
        $headers = $event['headers'];
        if ($headers === null || $headers === '') {
            throw new \BadMethodCallException("Headers not provided");
        }

        if (!isset($headers['access-token'])) {
            throw new \BadMethodCallException("Access Token not provided");
        }

        if ($headers['access-token'] != Credentials::$ACCESS_TOKEN) {
            throw new \BadMethodCallException("Incorrecto token");
        }
    }

    public static function validateMethod($event)
    {
        $method = $event['requestContext']['http']['method'];
        if (!in_array($method, ServerController::$methodsAllowed)) {
            throw new \BadMethodCallException("Method " . $event['requestContext']['http']['method'] . " is not allowed");
        }

    }

    public static function validateRoute($event)
    {
        $params = $event['queryStringParameters'];
        if (!isset($params['route'])) {
            throw new \BadMethodCallException("Route not provided");
        }
    }
}