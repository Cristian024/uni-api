<?php

namespace App\Helpers;

class DatabaseHelper
{

    public static function getParams($entity, $method)
    {
        try {
            $data = RequestHelper::getParams();
            return DatabaseHelper::extractParams($entity, $data, $method);
        } catch (\UnexpectedValueException $e) {
            throw new \UnexpectedValueException($e->getMessage());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
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
                } else if (is_null($value)) {
                    $values[] = "NULL";
                } else {
                    $values[] = "'" . $value . "'";
                }
                $count++;
            } else if ($key !== 'id') {
                throw new \UnexpectedValueException("$entity.Class: param $key is not accepted");
            }
        }

        if (count($attributes) - 1 != $count && $method == 'insert') {
            throw new \Exception("$entity.Class: Missing params");
        } else if ($count == 0 && $method == 'update') {
            throw new \Exception("$entity.Class: Missing params");
        } else {
            return [$columns, $values];
        }
    }
}