<?php

namespace App\Controllers\General;

use Config\Database;
use App\Helpers\DatabaseHelper;
use App\Controllers\General\ResponseController;

class DataBaseController
{
    public static function executeConsult($sql)
    {
        try {
            $connection = new Database();

            $result = $connection->query($sql->getSql());

            if ($result) {
                $data = array();
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }

                return $data;
            } else {
                throw new \PDOException("SQL Error: " . $connection->error);
            }
        } catch (\PDOException $e) {
            throw new \Exception("SQL Error: " . $e->getMessage());
        } catch (\Exception $e) {
            throw new \Exception("Internal Server Error: " . $e->getMessage());
        }
    }

    public static function executeInsert($table, $entity, $fields)
    {
        try {
            $connection = new Database();

            if ($fields === null)
                $fields = DatabaseHelper::getParams($entity, 'insert');

            $sql = 'INSERT INTO ' . $table . ' (' . implode(', ', $fields[0]) . ') VALUES (' . implode(', ', $fields[1]) . ')';

            $result = $connection->query($sql);

            if ($result) {
                $insertClass = new \stdClass;
                $insertClass->id = $connection->insert_id;
                return $insertClass;
            } else {
                throw new \PDOException("SQL Error: " . $connection->error);
            }
        } catch (\PDOException $e) {
            throw new \PDOException("SQL Error: " . $connection->error);
        } catch (\UnexpectedValueException $e) {
            throw new \UnexpectedValueException($e->getMessage());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function executeUpdate($table, $entity, $fields, $filter)
    {
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

            $sql .= $filter;

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

    public static function executeDelete($sql)
    {
        $connection = new Database();
        try {

            $result = $connection->query($sql->getSql());

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