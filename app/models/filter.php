<?php

namespace App\Models;

class Filter
{
    public static function _create()
    {
        return new class () {
            private $sql;

            public function __construct()
            {
                $this->sql = '';
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

            public function _in($column,$list)
            {   
                $this->sql .= " $column IN (" . implode(', ', $list) . ") ";
                return $this;
            }

            public function getSql()
            {
                return $this->sql;
            }
        };
    }
}