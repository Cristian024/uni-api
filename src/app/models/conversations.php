<?php

namespace App\Models;

use App\Controllers\General\ResponseController;
use App\Helpers\RequestHelper;

class Conversations extends Model
{
    public $id;
    public $user_one_id;
    public $user_two_id;
    public $last_message;
    public $last_message_date;
    public $last_message_from;

    public function __construct($id, $user_one_id, $user_two_id, $last_message, $last_message_date, $last_message_from)
    {
        $this->id = $id;
        $this->user_one_id = $user_one_id;
        $this->user_two_id = $user_two_id;
        $this->last_message = $last_message;
        $this->last_message_date = $last_message_date;
        $this->last_message_from = $last_message_from;
    }

    public static function getConversationByUsers($data)
    {
        if ($data != null) {
            $params = $data;
            if (!isset($params->user_one_id))
                throw new \UnexpectedValueException('User One not provided');

            if (!isset($params->user_two_id))
                throw new \UnexpectedValueException('User Two not provided');

            $user_one = $params->user_one_id;
            $user_two = $params->user_two_id;
        } else {
            $params = RequestHelper::getParams();

            if (!isset($params['user_one_id']))
                throw new \UnexpectedValueException('User One not provided');

            if (!isset($params['user_two_id']))
                throw new \UnexpectedValueException('User Two not provided');

            $user_one = $params['user_one_id'];
            $user_two = $params['user_two_id'];
        }

        $filter = Filter::_create()->_oppar()->_eq('user_one_id', $user_one)->_and()->_eq('user_two_id', $user_two)->_clpar()
            ->_or()->_oppar()->_eq('user_one_id', $user_two)->_and()->_eq('user_two_id', $user_one)->_clpar();

        $result = Conversations::_consult()->_all()->_cmsel()->_filter($filter)->_init();

        if (sizeof($result) > 0) {
            RequestHelper::$QUERYID = $result[0]['id'];
            return Conversations::getConversationById();
        } else {
            $c_conversation = new Conversations(null, $user_one, $user_two, null, null, null);
            $result_i = Conversations::_insert($c_conversation)->_init();
            RequestHelper::$QUERYID = $result_i->id;
            return Conversations::getConversationById();
        }
    }

    public static function getConversationById()
    {
        $conversation_obj = new \stdClass;
        $id = RequestHelper::getIdParam();
        $filter_c = Filter::_create()->_eq('id', $id);
        $filter_m = Filter::_create()->_eq('conversation_id', $id);

        $conversation = Conversations::_consult()->_all()->_cmsel()->_filter($filter_c)->_init();
        $count_messages = Messages::getCountMessages($filter_m);

        $conversation_obj->count_messages = (int) $count_messages[0]['count_messages'];
        $conversation_obj->conversation = $conversation[0];
        return $conversation_obj;
    }
}