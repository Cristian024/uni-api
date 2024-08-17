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
            ServerController::validateToken();
            ServerController::validateMethod();
            ServerController::validateRoute();
        } catch (\BadMethodCallException $e) {
            throw new \BadMethodCallException($e->getMessage());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function getEvent()
    {
        ResponseController::sentSuccessflyResponse(RequestHelper::$COOKIES);
    }

    public static function validateIncomingEvent($event)
    {
        RequestHelper::$EVENT = $event;

        if (!isset($event['queryStringParameters'])) {
            throw new \BadMethodCallException("Query String parameters not provided ");
        } else {
            RequestHelper::$PARAMS = $event['queryStringParameters'];
            if(isset($event['queryStringParameters']['id'])){
                RequestHelper::$QUERYID = $event['queryStringParameters']['id'];
            }
        }

        if (!isset($event['requestContext'])) {
            throw new \BadMethodCallException("Request context not provided ");
        } else {
            $requestContext = $event['requestContext'];
            if (isset($requestContext['httpMethod'])) {
                RequestHelper::$HTTP = $requestContext['httpMethod'];
            } else {
                throw new \BadMethodCallException("HTTP Method not provided");
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

        if (isset($event['headers']['Cookie'])) {
            $cookiesEvent = $event['headers']['Cookie'];
            $cookies = explode(";", $cookiesEvent);
            $cookiesTS = [];
            foreach ($cookies as $key => $value) {
                $explode = explode("=", $value);
                $cookie = [$explode[0] => $explode[1]];
                $cookiesTS[$key] = $cookie;
            }

            if (sizeof($cookiesTS) > 0) {
                RequestHelper::$COOKIES = $cookiesTS;
            }
        }
    }

    public static function validateToken()
    {
        $headers = RequestHelper::$HEADERS;
        if ($headers === null || $headers === '') {
            throw new \BadMethodCallException("Headers not provided");
        }

        if (!isset($headers['access-token'])) {
            throw new \BadMethodCallException("Access Token not provided");
        }

        if ($headers['access-token'] != Credentials::$ACCESS_TOKEN) {
            throw new \BadMethodCallException("Incorrect token");
        }
    }

    public static function validateMethod()
    {
        $method = RequestHelper::$HTTP;
        if (!in_array($method, ServerController::$methodsAllowed)) {
            throw new \BadMethodCallException("Method " . RequestHelper::$HTTP . " is not allowed");
        }
    }

    public static function validateRoute()
    {
        $params = RequestHelper::$PARAMS;
        if (!isset($params['route'])) {
            throw new \BadMethodCallException("Route not provided");
        }else{
            RequestHelper::$ROUTE = $params['route'];
        }
    }
}