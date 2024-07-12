<?php

namespace App\Controllers\General;

use Config\Database;
use App\Helpers\DatabaseHelper;
use App\Controllers\General\ResponseController;

class DataBaseController
{
    public static function executeConsult($sql)
    {
        global $queryId;

        $connection = new Database();
        try {

            $result = $connection->query($sql->getSql());

            if ($result) {
                $data = array();
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }

                return $data;
            } else {
                ResponseController::sentDatabaseErrorResponse($connection->error);
            }
        } catch (\PDOException $e) {
            ResponseController::sentDatabaseErrorResponse($e->getMessage());
        } catch (\Exception $e) {
            ResponseController::sentInternalErrorResponse($e->getMessage());
        }
    }

    public static function executeInsert($table, $entity, $fields)
    {
        $connection = new Database();
        try {
            if ($fields === null)
                $fields = DatabaseHelper::getParams($entity, 'insert');

            $sql = 'INSERT INTO ' . $table . ' (' . implode(', ', $fields[0]) . ') VALUES (' . implode(', ', $fields[1]) . ')';

            $result = $connection->query($sql);

            if ($result) {
                $insertClass = new \stdClass;
                $insertClass->id = $connection->insert_id;
                return $insertClass;
            } else {
                ResponseController::sentDatabaseErrorResponse($connection->error);
            }
        } catch (\PDOException $e) {
            ResponseController::sentDatabaseErrorResponse($e->getMessage());
        } catch (\Exception $e) {
            ResponseController::sentInternalErrorResponse($e->getMessage());
        }
    }

    public static function executeUpdate($table, $entity, $fields)
    {
        global $queryId;

        if ($queryId == null)
            ResponseController::sentBadRequestResponse('ID is required');

        $connection = new Database();
        try {
            if ($fields === null)
                $fields = DatabaseHelper::getParams($entity, 'update');

            $sql = "UPDATE $table SET ";

            $count = 0;
            for ($i = 0; $i < count($fields[0]); $i++) {
                if ($count === count($fields[0]) - 1) {
                    $sql .= '' . $fields[0][$i] . ' = ' . $fields[1][$i] . '';
                } else {
                    $sql .= '' . $fields[0][$i] . ' = ' . $fields[1][$i] . ', ';
                }
                $count++;
            }

            $sql .= " WHERE id = $queryId";

            $result = $connection->query($sql);

            if ($result) {
                $updateClass = new \stdClass;
                $updateClass->affected_rows = $connection->affected_rows;
                return $updateClass;
            } else {
                ResponseController::sentDatabaseErrorResponse($connection->error);
            }
        } catch (\PDOException $e) {
            ResponseController::sentDatabaseErrorResponse($e->getMessage());
        } catch (\Exception $e) {
            ResponseController::sentInternalErrorResponse($e->getMessage());
        }
    }

    public static function executeDelete($table, $filter)
    {
        global $queryId;

        if ($queryId == null)
            ResponseController::sentBadRequestResponse('ID is required');

        $connection = new Database();
        try {
            $sql = DatabaseHelper::createDeleteFilter('sessions')->addFilter($filter)->getSql();

            $result = $connection->query($sql);

            if ($result) {
                $deleteClass = new \stdClass;
                $deleteClass->affected_rows = $connection->affected_rows;
                return $deleteClass;
            } else {
                ResponseController::sentDatabaseErrorResponse($connection->error);
            }
        } catch (\PDOException $e) {
            ResponseController::sentDatabaseErrorResponse($e->getMessage());
        } catch (\Exception $e) {
            ResponseController::sentInternalErrorResponse($e->getMessage());
        }
    }
}