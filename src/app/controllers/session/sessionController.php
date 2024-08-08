<?php
namespace App\Controllers\Session;

use App\Controllers\General\ResponseController;
use App\Helpers\RequestHelper;
use App\Models\Sessions;

class SessionController
{
    public static function getAllSessions()
    {
        try {
            ResponseController::sentSuccessflyResponse(
                Sessions::_consult()->_all()->_cmsel()->_init()
            );
        } catch (\UnexpectedValueException $e) {
            ResponseController::sentBadRequestResponse($e->getMessage());
        } catch (\PDOException $e) {
            ResponseController::sentInternalErrorResponse($e->getMessage());
        } catch (\Exception $e) {
            ResponseController::sentInternalErrorResponse($e->getMessage());
        }
    }

    public static function getSessionById()
    {
        try {
            ResponseController::sentSuccessflyResponse(
                Sessions::_consult()->_all()->_cmsel()->_id(RequestHelper::getIdParam())->_init()
            );
        } catch (\UnexpectedValueException $e) {
            ResponseController::sentBadRequestResponse($e->getMessage());
        } catch (\PDOException $e) {
            ResponseController::sentInternalErrorResponse($e->getMessage());
        } catch (\Exception $e) {
            ResponseController::sentInternalErrorResponse($e->getMessage());
        }
    }

    public static function getSessionByUserId()
    {
        try {
            ResponseController::sentSuccessflyResponse(
                Sessions::_consult()->_all()->_cmsel()->_row('user_id', RequestHelper::getIdParam())->_init()
            );
        } catch (\UnexpectedValueException $e) {
            ResponseController::sentBadRequestResponse($e->getMessage());
        } catch (\PDOException $e) {
            ResponseController::sentInternalErrorResponse($e->getMessage());
        } catch (\Exception $e) {
            ResponseController::sentInternalErrorResponse($e->getMessage());
        }
    }

    public static function deleteSessionById()
    {
        try {
            ResponseController::sentSuccessflyResponse(
                Sessions::_delete()->_id(RequestHelper::getIdParam())->_init()
            );
        } catch (\UnexpectedValueException $e) {
            ResponseController::sentBadRequestResponse($e->getMessage());
        } catch (\PDOException $e) {
            ResponseController::sentInternalErrorResponse($e->getMessage());
        } catch (\Exception $e) {
            ResponseController::sentInternalErrorResponse($e->getMessage());
        }
    }

    public static function deleteSessionByUserId()
    {
        try {
            ResponseController::sentSuccessflyResponse(
                Sessions::_delete()->_row('user_id', RequestHelper::getIdParam())->_init()
            );
        } catch (\UnexpectedValueException $e) {
            ResponseController::sentBadRequestResponse($e->getMessage());
        } catch (\PDOException $e) {
            ResponseController::sentInternalErrorResponse($e->getMessage());
        } catch (\Exception $e) {
            ResponseController::sentInternalErrorResponse($e->getMessage());
        }
    }

    public static function validateSessionStudent()
    {
        try {
            ResponseController::sentSuccessflyResponse(Sessions::validateSession('student'));
        } catch (\UnexpectedValueException $e) {
            ResponseController::sentBadRequestResponse($e->getMessage());
        } catch (\PDOException $e) {
            ResponseController::sentInternalErrorResponse($e->getMessage());
        } catch (\Exception $e) {
            ResponseController::sentInternalErrorResponse($e->getMessage());
        }
    }

    public static function validateSessionEnterprise()
    {
        try {
            ResponseController::sentSuccessflyResponse(Sessions::validateSession('enterprise'));
        } catch (\UnexpectedValueException $e) {
            ResponseController::sentBadRequestResponse($e->getMessage());
        } catch (\PDOException $e) {
            ResponseController::sentInternalErrorResponse($e->getMessage());
        } catch (\Exception $e) {
            ResponseController::sentInternalErrorResponse($e->getMessage());
        }
    }

    public static function validateSessionAny()
    {
        try {
            ResponseController::sentSuccessflyResponse(Sessions::validateSession('any'));
        } catch (\UnexpectedValueException $e) {
            ResponseController::sentBadRequestResponse($e->getMessage());
        } catch (\PDOException $e) {
            ResponseController::sentInternalErrorResponse($e->getMessage());
        } catch (\Exception $e) {
            ResponseController::sentInternalErrorResponse($e->getMessage());
        }
    }
}