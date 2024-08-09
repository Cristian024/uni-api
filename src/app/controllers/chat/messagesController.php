<?php

namespace App\Controllers\Chat;

use App\Controllers\General\ResponseController;
use App\Helpers\RequestHelper;
use App\Models\Conversations;
use App\Models\Messages;
use App\Models\Filter;

class MessagesController
{
    public static function getMessagesByConversationId()
    {
        $params = RequestHelper::getParams();

        if (!isset($params['conversation_id']))
            throw new \UnexpectedValueException('Conversation id is required');

        if (!isset($params['limit']))
            throw new \UnexpectedValueException('Limit is required');

        if (!isset($params['offset']))
            throw new \UnexpectedValueException('Offset is required');

        $id = $params['conversation_id'];
        $limit = $params['limit'];
        $offset = $params['offset'];

        $filter = Filter::_create()->_eq('conversation_id', $id)->_ordes('cdate')->_lim($limit)->_off($offset);
        ResponseController::sentSuccessflyResponse(
            Messages::_consult()->_all()->_cmsel()->_filter($filter)->_init()
        );
    }

    public static function insertMessage()
    {
        $rs_inserMsg = Messages::_insert(null)->_init();

        $params = RequestHelper::getParams();

        $conv_upd = new \stdClass;
        $conv_upd->last_message = $params['phrase'];
        $conv_upd->last_message_date = $params['cdate'];
        $conv_upd->last_message_from = $params['user_post'];

        Conversations::_update()->_data($conv_upd)->_id($params['conversation_id'])->_init();

        ResponseController::sentSuccessflyResponse($rs_inserMsg->id);
    }

    public static function updateMessageStateList()
    {
        $params = RequestHelper::getParams();

        if (!isset($params['state']))
            throw new \UnexpectedValueException('State field is required');

        if (!isset($params['list']))
            throw new \UnexpectedValueException('Messages list is required');


        $state = $params['state'];
        $list = $params['list'];
        $message_ids = [];

        foreach ($list as $message) {
            if (isset($message['id'])) {
                $message_ids[] = $message['id'];
            }
        }

        $filter = Filter::_create()->_in('id', $message_ids);
        $result = Messages::_update()->_column('state', $state)->_filter($filter)->_init();

        $response = new \stdClass;
        $response->affected_rows = $result->affected_rows;
        $response->messages = $message_ids;
        $response->state = $state;

        ResponseController::sentSuccessflyResponse($response);
    }
}