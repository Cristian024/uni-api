<?php

namespace App\Models;

use App\Helpers\DatabaseHelper;
use App\Controllers\General\DataBaseController;

class Model
{
    public static function getTableName()
    {
        $calledClass = get_called_class();
        $className = (new \ReflectionClass($calledClass))->getShortName();
        return strtolower($className);
    }

    public static function _consult()
    {
        $table = static::getTableName();
        return new class ($table) {
            private $sql;
            private $table;

            public function __construct($table)
            {
                $this->sql = "SELECT ";
                $this->table = $table;
            }

            public function _all()
            {
                $this->sql .= " $this->table.* ";
                return $this;
            }

            public function _rows($rows)
            {
                $this->sql .= $rows;
                return $this;
            }

            public function _injoin($tjoin, $trowjoin, $row)
            {
                $this->sql .= " INNER JOIN $tjoin ON $this->table.$row = $tjoin.$trowjoin ";
                return $this;
            }

            public function _cmsel()
            {
                $this->sql .= " FROM $this->table";
                return $this;
            }

            public function _filter($filter)
            {
                if ($filter != null)
                    $this->sql .= " WHERE " . $filter->getSql();
                return $this;
            }

            public function _id($id)
            {
                $this->sql .= " WHERE id = $id";
                return $this;
            }

            public function _row($row, $value)
            {
                $this->sql .= " WHERE $row = $value";
                return $this;
            }

            public function getSql()
            {
                return $this->sql;
            }
            public function _init()
            {
                return DataBaseController::executeConsult($this);
            }
        };
    }

    public static function _insert($data)
    {
        $class = get_called_class();
        $table = static::getTableName();
        return new class ($data, $class, $table) {
            private $fields = null;
            private $class;
            private $table;

            public function __construct($data, $class, $table)
            {
                $this->table = $table;
                $this->class = $class;
                if ($data != null) {
                    $this->fields = DatabaseHelper::extractParams($class, $data, 'insert');
                }
            }

            public function _init()
            {
                return DataBaseController::executeInsert($this->table, $this->class, $this->fields);
            }
        };
    }

    public static function _update($data)
    {
        $class = get_called_class();
        $table = static::getTableName();
        return new class ($data, $class, $table) {
            private $fields = null;
            private $class;
            private $table;
            private $filter;

            public function __construct($data, $class, $table)
            {
                $this->table = $table;
                $this->class = $class;
                if ($data != null) {
                    $this->fields = DatabaseHelper::extractParams($class, $data, 'update');
                }
            }

            public function _filter($filter)
            {
                $this->filter = $filter;
                return $this;
            }

            public function _id($id)
            {
                $this->filter .= " WHERE id = $id";
                return $this;
            }

            public function _row($row, $value)
            {
                $this->filter .= " WHERE $row = $value";
                return $this;
            }

            public function _init()
            {
                return DataBaseController::executeUpdate($this->table, $this->class, $this->fields, $this->filter);
            }
        };
    }

    public static function _delete()
    {
        $table = static::getTableName();
        return new class ($table) {
            private $table;
            private $filter;
            private $sql;

            public function __construct($table)
            {
                $this->table = $table;
                $this->sql = "DELETE FROM $table ";
            }

            public function _filter($filter)
            {
                $this->sql .= " WHERE " . $filter->getSql();
                return $this;
            }

            public function _id($id)
            {
                $this->sql .= " WHERE id = $id";
                return $this;
            }

            public function _row($row, $value)
            {
                $this->sql .= " WHERE $row = $value";
                return $this;
            }

            public function getSql()
            {
                return $this->sql;
            }

            public function _init()
            {
                return DataBaseController::executeDelete($this);
            }
        };
    }
}