<?php

namespace App\Models;

class Response
{
    #OK REQUEST
    static $SUCCESSFLY_CODE = 200;
    static $SUCCESSFLY_MESSAGE = 'Action successfully completed';

    #BAD REQUEST
    static $BAD_REQUEST_CODE = 400;
    static $BAD_REQUEST_MESSAGE = 'Bad request';

    static $UNAUTHORIZED_CODE = 401;
    static $UNAUTHORIZED_MESSAGE = 'You are not authorized to perform this action';

    static $NOT_FOUND_CODE = 404;
    static $NOT_FOUND_MESSAGE = 'Action not found';

    static $METHOD_NOT_ALLOWED_CODE = 405;
    static $METHOD_NOT_ALLOWED_MESSAGE = 'Method not enabled';

    static $MISSING_PARAMS_CODE = 406;
    static $MISSING_PARAMS_MESSAGE = 'Missing params';


    #SERVER ERROR
    static $INTERNAL_SERVER_CODE = 500;
    static $INTERNAL_SERVER_MESSAGE = 'Internal server error';

    static $SQL_ERROR_CODE = 501;
    static $SQL_ERROR_MESSAGE = 'Database error';

    public $code;
    public $message;
    public $data;
    public $error;

    public function __construct($code, $message, $data, $error)
    {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
        $this->error = $error;
    }
}