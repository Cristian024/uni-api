<?php

namespace App\Models;

use App\Controllers\General\DataBaseController;
use App\Helpers\DatabaseHelper;
use App\Helpers\RequestHelper;

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

        $contacts = [];

        if (sizeof($result) > 0) {
            $contacts = json_decode($result[0]['contacts']);
            $contacts_c = [];

            if (sizeof($contacts) > 0) {
                foreach ($contacts as $index => $contact) {
                    $filter_u = DatabaseHelper::createFilterCondition('')->_eq('user_id', $contact->user_id);
                    $result_c = null;

                    $result_e = Enterprise::getEnterprise($filter_u);
                    $result_s = Student::getStudent($filter_u);

                    if (sizeof($result_e) > 0) {
                        $result_c = $result_e[0];
                    } else if (sizeof($result_s) > 0) {
                        $result_c = $result_s[0];
                    }

                    $last_message = null;
                    $last_message_date = null;
                    $last_message_from = null;
                    if ($contact->conversation_id != null) {
                        $filter_c = DatabaseHelper::createFilterCondition('')->_eq('id', $contact->conversation_id);
                        $result_co = Conversation::getConversation($filter_c);

                        if (sizeof($result_co) > 0) {
                            $conversation = $result_co[0];
                            $last_message = $conversation['last_message'];
                            $last_message_date = $conversation['last_message_date'];
                            $last_message_from = $conversation['last_message_from'];
                        }
                    }

                    $contacts_c[] = $result_c;
                    $contacts[$index]->contact_info = $contacts_c;
                    $contacts[$index]->last_message = $last_message;
                    $contacts[$index]->last_message_date = $last_message_date;
                    $contacts[$index]->last_message_from = $last_message_from;
                }
            }

            return $contacts;
        }else{
            return $contacts;
        }
    }

    public static function updateContacts($data)
    {
        return DataBaseController::executeUpdate('contacts', Contact::class, $data);
    }
}