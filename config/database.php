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
                $_ENV['SERVER'],
                $_ENV['USER'],
                $_ENV['PASSWORD'],
                $_ENV['DATABASE'],
                $_ENV['PORT']
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