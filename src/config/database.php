<?php

namespace Config;

use App\Controllers\General\ResponseController;
use Config\Credentials;
class Database extends \mysqli
{
    function __construct()
    {
        try {
            parent::__construct(
                Credentials::$SERVER,
                Credentials::$USER,
                Credentials::$PASSWORD,
                Credentials::$DATABASE,
                Credentials::$PORT
            );
            $this->set_charset('utf8');
            $this->connect_error != null ? ResponseController::sentDatabaseErrorResponse($this->error) : '';
        } catch (\PDOException $e) {
            ResponseController::sentDatabaseErrorResponse($e->getMessage());
        } catch (\Exception $e){
            ResponseController::sentInternalErrorResponse($e->getMessage());
        }
    }
}