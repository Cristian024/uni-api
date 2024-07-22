<?php

namespace App\Models;

use App\Controllers\General\DataBaseController;
use App\Helpers\DatabaseHelper;

class Enterprises extends Model
{
    public $id;
    public $name;
    public $nit;
    public $cellphone;
    public $web;
    public $direction;
    public $user_id;

    function __construct($id, $name, $nit, $cellphone, $web, $direction, $user_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->nit = $nit;
        $this->cellphone = $cellphone;
        $this->web = $web;
        $this->direction = $direction;
        $this->user_id = $user_id;
    }
}