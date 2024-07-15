<?php

namespace App\Controllers\Chat;
use App\Controllers\General\ResponseController;
use App\Helpers\DatabaseHelper;
use App\Helpers\RequestHelper;
use App\Models\Message;

class MessagesController{
    public static function getMessagesByConversationId(){
        $params = RequestHelper::getParams();

        if(!isset($params['conversation_id']))
            ResponseController::sentBadRequestResponse('Conversation id is required');

        $id = $params['conversation_id'];

        $filter = DatabaseHelper::createFilterCondition('')->_eq('conversation_id', $id);
        ResponseController::sentSuccessflyResponse(Message::getMessage($filter));
    }

    public static function insertMessage(){
        ResponseController::sentSuccessflyResponse(Message::insertMessage(null));
    }
}