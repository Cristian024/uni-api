<?php

namespace App\Models;

use App\Controllers\General\DataBaseController;
use App\Helpers\DatabaseHelper;

class Enterprise
{
    public $id;
    public $name;
    public $nit;
    public $user_id;

    function __construct($id, $name, $nit, $user_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->nit = $nit;
        $this->user_id = $user_id;
    }

    public static function getEnterprise($filter)
    {
        $sql = DatabaseHelper::createFilterRows("enterprises", "e")->_rows("e.*,users.email")->_cmsel()
            ->_injoin("user_id", "id", "users")->addFilter($filter);
        return DataBaseController::executeConsult($sql);
    }

    public static function insertEnterprise($data)
    {
        return DataBaseController::executeInsert("enterprises", Enterprise::class, $data);
    }

    public static function updateEnterprise($data)
    {
        return DataBaseController::executeUpdate("enterprises", Enterprise::class, $data);
    }
}