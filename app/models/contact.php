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
        $sql = DatabaseHelper::createFilterRows("contacts", "c")->_all()->_cmsel()->addFilter($filter);
        $result = DataBaseController::executeConsult($sql);

        $contacts = json_decode($result[0]['contacts']);
        $contacts_c = [];

        if (sizeof($contacts) > 0) {
            foreach ($contacts as $index => $contact) {
                $filter_c = DatabaseHelper::createFilterCondition('')->_eq('user_id', $contact->user_id);
                $result_c = null;

                $result_e = Enterprise::getEnterprise($filter_c);
                $result_s = Student::getStudent($filter_c);

                if (sizeof($result_e) > 0) {
                    $result_c = $result_e[0];
                } else if (sizeof($result_s) > 0) {
                    $result_c = $result_s[0];
                }

                $contacts_c[] = $result_c;
                $contacts[$index]->contact_info = $contacts_c;
            }
        }

        return $contacts;
    }

    public static function updateContacts($data)
    {
        return DataBaseController::executeUpdate('contacts', Contact::class, $data);
    }
}