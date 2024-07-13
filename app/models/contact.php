<?php

namespace App\Models;

use App\Controllers\General\DataBaseController;
use App\Helpers\DatabaseHelper;

class Contact
{
    public $id;
    public $user_id;
    public $contacts;

    public function __construct($id, $user_id, $contacts)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->contacts = $contacts;
    }

    public static function getContacts($filter)
    {
        $sql = DatabaseHelper::createFilterRows("contacts", "c")->_all()->addFilter($filter);
        return DataBaseController::executeConsult($sql);
    }

    public static function updateContacts($data)
    {
        return DataBaseController::executeUpdate('contacts', Contact::class, $data);
    }
}