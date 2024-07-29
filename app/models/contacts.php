<?php

namespace App\Models;

class Contacts extends Model
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
        $result = Contacts::_consult()->_all()->_cmsel()->_filter($filter)->_init();

        $contacts = [];

        if (sizeof($result) > 0) {
            $contacts = json_decode($result[0]['contacts']);
            $contacts_c = [];

            if (sizeof($contacts) > 0) {
                foreach ($contacts as $index => $contact) {
                    $filter_u = Filter::_create()->_eq('user_id', $contact->user_id);
                    $result_c = null;

                    $result_e = Enterprises::_consult()->_rows('enterprises.*,users.role')->_cmsel()->
                        _injoin('users', 'id', 'user_id')->_filter($filter_u)->_init();
                    $result_s = Students::_consult()->_rows('students.*,users.role')->_cmsel()->
                        _injoin('users', 'id', 'user_id')->_filter($filter_u)->_init();

                    if (sizeof($result_e) > 0) {
                        $result_c = $result_e[0];
                    } else if (sizeof($result_s) > 0) {
                        $result_c = $result_s[0];
                    }

                    $last_message = null;
                    $last_message_date = null;
                    $last_message_from = null;
                    if ($contact->conversation_id != null) {
                        $filter_c = Filter::_create()->_eq('id', $contact->conversation_id);
                        $result_co = Conversations::_consult()->_all()->_cmsel()->_filter($filter_c)->_init();

                        if (sizeof($result_co) > 0) {
                            $conversation = $result_co[0];
                            
                            $last_message = $conversation['last_message'];
                            $last_message_date = $conversation['last_message_date'];
                            $last_message_from = $conversation['last_message_from'];
                        } else {
                            $users = new \stdClass;
                            $users->user_one_id = $result[0]['user_id'];
                            $users->user_two_id = $contact->user_id;
                            $conversation = Conversations::getConversationByUsers($users);

                            $contacts[$index]->conversation_id = $conversation->conversation['id'];
                            Contacts::_update()->_column('contacts', json_encode($contacts))->_id($result[0]['id'])->_init();

                            $last_message = $conversation->conversation['last_message'];
                            $last_message_date = $conversation->conversation['last_message_date'];
                            $last_message_from = $conversation->conversation['last_message_from'];
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
        } else {
            return $contacts;
        }
    }
}