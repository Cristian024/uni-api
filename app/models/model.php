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

            public function _lejoin($ljoin, $trowleft, $row)
            {
                $this->sql .= " LEFT JOIN $ljoin ON $this->table.$row = $ljoin.$trowleft ";
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

            public function _case()
            {
                $this->sql .= " CASE ";
                return $this;
            }

            public function _ecase($nick)
            {
                $this->sql .= " END AS '$nick'";
                return $this;
            }

            public function _when($col, $row, $then)
            {
                $this->sql .= " WHEN $col = '$row' THEN $then";
                return $this;
            }

            public function _else($value)
            {
                $this->sql .= " ELSE $value ";
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

    public static function _update()
    {
        $class = get_called_class();
        $table = static::getTableName();
        return new class ($class, $table) {
            private $fields = null;
            private $class;
            private $table;
            private $filter;

            public function __construct($class, $table)
            {
                $this->table = $table;
                $this->class = $class;
            }

            public function _column($column, $value)
            {
                $this->fields = [[$column], ["'" . $value . "'"]];
                return $this;
            }

            public function _data($data)
            {
                $this->fields = DatabaseHelper::extractParams($this->class, $data, 'update');
                return $this;
            }

            public function _filter($filter)
            {
                $this->filter = " WHERE " . $filter->getSql();
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