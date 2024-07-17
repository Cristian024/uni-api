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
    public static function createFilterCondition($sql)
    {
        return new class ($sql) {
            private $sql;

            public function __construct($sql)
            {
                $this->sql = $sql;
            }

            public function _eq($row, $value)
            {
                $this->sql .= "" . $row . " = '" . $value . "'";
                return $this;
            }

            public function _gre($row, $value)
            {
                $this->sql .= "" . $row . " > '" . $value . "'";
                return $this;
            }

            public function _greq($row, $value)
            {
                $this->sql .= "" . $row . " >= '" . $value . "'";
                return $this;
            }

            public function _less($row, $value)
            {
                $this->sql .= "" . $row . " < '" . $value . "'";
                return $this;
            }

            public function _lessq($row, $value)
            {
                $this->sql .= "" . $row . " <= '" . $value . "'";
                return $this;
            }

            public function _neq($row, $value)
            {
                $this->sql .= "" . $row . " != '" . $value . "'";
                return $this;
            }

            public function _like($row, $value)
            {
                $this->sql .= "" . $row . " LIKE '%" . $value . "%'";
                return $this;
            }

            public function _null($row)
            {
                $this->sql .= "" . $row . " IS NULL";
                return $this;
            }

            public function _notnull($row)
            {
                $this->sql .= "" . $row . " IS NOT NULL";
                return $this;
            }

            public function _and()
            {
                $this->sql .= " AND ";
                return $this;
            }

            public function _or()
            {
                $this->sql .= " OR ";
                return $this;
            }

            public function _oppar()
            {
                $this->sql .= " ( ";
                return $this;
            }

            public function _clpar()
            {
                $this->sql .= " ) ";
                return $this;
            }

            public function _ordes($row)
            {
                $this->sql .= " ORDER BY " . $row . " DESC";
                return $this;
            }

            public function _ordas($row)
            {
                $this->sql .= " ORDER BY " . $row . "";
                return $this;
            }

            public function _lim($limit)
            {
                $this->sql .= " LIMIT " . $limit . " ";
                return $this;
            }

            public function _off($offset)
            {
                $this->sql .= " OFFSET " . $offset . "";
                return $this;
            }

            public function getSql()
            {
                return $this->sql;
            }
        };
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

            public function addFilter($filter)
            {
                if ($filter != null)
                    $this->sql .= " WHERE " . $filter->getSql() . "";
                return $this;
            }

            public function getSql()
            {
                return $this->sql;
            }
        };
    }

    public static function createDeleteFilter($table)
    {
        return new class ($table) {
            private $sql;

            public function __construct($table)
            {
                $this->sql = 'DELETE FROM ' . $table . ' ';
            }

            public function addFilter($filter)
            {
                if ($filter != null)
                    $this->sql .= " WHERE " . $filter->getSql() . "";
                return $this;
            }

            public function getSql()
            {
                return $this->sql;
            }
        };
    }
}