<?php

namespace App\Controllers\Chat;

use App\Controllers\General\ResponseController;
use App\Helpers\DatabaseHelper;
use App\Helpers\RequestHelper;
use App\Models\Conversation;
use App\Models\Message;

class MessagesController
{
    public static function getMessagesByConversationId()
    {
        $params = RequestHelper::getParams();

        if (!isset($params['conversation_id']))
            ResponseController::sentBadRequestResponse('Conversation id is required');

        if (!isset($params['limit']))
            ResponseController::sentBadRequestResponse('Limit is required');

        if (!isset($params['offset']))
            ResponseController::sentBadRequestResponse('Offset is required');

        $id = $params['conversation_id'];
        $limit = $params['limit'];
        $offset = $params['offset'];

        $filter = DatabaseHelper::createFilterCondition('')->_eq('conversation_id', $id)->_ordas('cdate')->_lim($limit)->_off($offset);
        ResponseController::sentSuccessflyResponse(Message::getMessage($filter));
    }

    public static function insertMessage()
    {
        global $queryId;
        $rs_inserMsg = Message::insertMessage(null);

        $params = RequestHelper::getParams();

        $conv_upd = new \stdClass;
        $conv_upd->last_message = $params['phrase'];
        $conv_upd->last_message_date = $params['cdate'];
        $conv_upd->last_message_from = $params['user_post'];

        $queryId = $params['conversation_id'];

        Conversation::updateConversation(DatabaseHelper::extractParams(Conversation::class, $conv_upd, 'update'));

        ResponseController::sentSuccessflyResponse($rs_inserMsg);
    }
}