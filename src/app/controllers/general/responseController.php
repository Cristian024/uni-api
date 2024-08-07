<?php

namespace App\Controllers\General;

use App\Models\Response;

class ResponseController
{
    public static $COOKIES_TO_SEND = [];

    public static function sentSuccessflyResponse($data)
    {
        ResponseController::returnResponse(
            new Response(
                Response::$SUCCESSFLY_CODE,
                Response::$SUCCESSFLY_MESSAGE,
                $data,
                null
            )
        );
    }

    public static function sentBadRequestResponse($message_error)
    {
        ResponseController::returnResponse(
            new Response(
                Response::$BAD_REQUEST_CODE,
                Response::$BAD_REQUEST_MESSAGE,
                null,
                $message_error
            )
        );
    }

    public static function sentUnauthorizedResponse($message_error)
    {
        ResponseController::returnResponse(
            new Response(
                Response::$UNAUTHORIZED_CODE,
                Response::$UNAUTHORIZED_MESSAGE,
                null,
                $message_error
            )
        );
    }

    public static function sentNotFoundResponse($message_error)
    {
        ResponseController::returnResponse(
            new Response(
                Response::$NOT_FOUND_CODE,
                Response::$NOT_FOUND_MESSAGE,
                null,
                $message_error
            )
        );
    }

    public static function sentMethodNotAllowedResponse()
    {
        ResponseController::returnResponse(
            new Response(
                Response::$METHOD_NOT_ALLOWED_CODE,
                Response::$METHOD_NOT_ALLOWED_MESSAGE,
                null,
                'Methods allowed: GET, POST, DELETE, PUT'
            )
        );
    }

    public static function sentMissingParamasResponse($message_error)
    {
        ResponseController::returnResponse(
            new Response(
                Response::$MISSING_PARAMS_CODE,
                Response::$MISSING_PARAMS_MESSAGE,
                null,
                $message_error
            )
        );
    }

    public static function sentInternalErrorResponse($message_error)
    {
        ResponseController::returnResponse(
            new Response(
                Response::$INTERNAL_SERVER_CODE,
                Response::$INTERNAL_SERVER_MESSAGE,
                null,
                $message_error
            )
        );
    }

    public static function sentDatabaseErrorResponse($message_error)
    {
        ResponseController::returnResponse(
            new Response(
                Response::$SQL_ERROR_CODE,
                Response::$SQL_ERROR_MESSAGE,
                null,
                $message_error
            )
        );
    }

    private static function returnResponse(Response $response)
    {
        $cookies = ResponseController::$COOKIES_TO_SEND;
        $headers = [
            'Content-Type' => 'application/json'
        ];

        if (sizeof($cookies) > 0) {
            foreach ($cookies as $cookie) {
                $headers['Set-Cookie'] = $cookie;
            }
        }

        echo json_encode([
            'statusCode' => $response->code,
            'headers' => $headers,
            'body' => json_encode([
                'status' => 'error',
                'error' => $response->error,
                'data' => $response->data
            ])
        ]);
    }
}