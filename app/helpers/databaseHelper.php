<?php

namespace App\Helpers;

use App\Controllers\General\ResponseController;

class DatabaseHelper
{
    public static function getParams($entity, $method)
    {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            return DatabaseHelper::extractParams($entity, $data, $method);
        } catch (\Exception $e) {
            ResponseController::sentInternalErrorResponse($e->getMessage());
        }
    }

    public static function extractParams($entity, $data, $method)
    {
        $count = 0;
        $columns = [];
        $values = [];
        $attributes = get_class_vars($entity);
        foreach ($data as $key => $value) {
            if (array_key_exists($key, $attributes) && $key !== 'id') {
                $columns[] = $key;
                if (is_int($value) || is_float($value) || is_double($value)) {
                    $values[] = "$value";
                } else if (is_bool($value)) {
                    $values[] = $value ? "'true'" : "'false'";
                } else {
                    $values[] = "'" . $value . "'";
                }
                $count++;
            } else if ($key !== 'id') {
                ResponseController::sentBadRequestResponse('' . $entity . 'Class: param `' . $key . '` is not accepted');
            }
        }

        if (count($attributes) - 1 != $count && $method == 'insert') {
            ResponseController::sentBadRequestResponse('' . $entity . 'Class: Missing params');
        } else {
            return [$columns, $values];
        }
    }
    
    public static function createFilterRows($table, $nick)
    {
        return new class ($table, $nick) {
            private $sql;
            private $table;
            private $nick;

            public function __construct($table, $nick)
            {
                $this->sql = "SELECT ";
                $this->table = $table;
                $this->nick = $nick;
            }

            public function _all()
            {
                $this->sql .= "" . $this->nick . ".*";
                return $this;
            }

            public function _rows($rows)
            {
                $this->sql .= $rows;
                return $this;
            }

            public function _injoin($ftable, $fjtable, $tjoin)
            {
                $this->sql .= " INNER JOIN " . $tjoin . " ON " . $this->nick . "." . $ftable . " = " . $tjoin . "." . $fjtable . "";
                return $this;
            }

            public function _cmsel()
            {
                $this->sql .= " FROM " . $this->table . " AS " . $this->nick . "";
                return $this;
            }

            public function getSql()
            {
                return $this->sql;
            }
        };
    }
}