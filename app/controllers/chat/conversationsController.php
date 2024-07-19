<?php

namespace App\Controllers\Chat;

use App\Controllers\General\ResponseController;
use App\Helpers\DatabaseHelper;
use App\Helpers\RequestHelper;
use App\Models\Conversation;
use App\Models\Message;

class ConversationsController
{
    public static function getConversationById()
    {
        $conversation_obj = new \stdClass;
        $id = RequestHelper::getIdParam();
        $filter_c = DatabaseHelper::createFilterCondition('')->_eq('id', $id);
        $filter_m = DatabaseHelper::createFilterCondition('')->_eq('conversation_id', $id);

        $conversation = Conversation::getConversation($filter_c);
        $count_messages = Message::getCountMessages($filter_m);

        $conversation_obj->count_messages = $count_messages[0]['count_messages'];
        $conversation_obj->conversation = $conversation[0];
        ResponseController::sentSuccessflyResponse($conversation_obj);
    }

    public static function getConversationByUsers()
    {
        $params = RequestHelper::getParams();

        if (!isset($params['user_one_id']))
            ResponseController::sentBadRequestResponse('User One not provided');

        if (!isset($params['user_two_id']))
            ResponseController::sentBadRequestResponse('User Two not provided');

        $user_one = $params['user_one_id'];
        $user_two = $params['user_two_id'];

        $filter = DatabaseHelper::createFilterCondition('')->_oppar()->_eq('user_one_id', $user_one)->_and()->_eq('user_two_id', $user_two)->_clpar()
        ->_or()->_oppar()->_eq('user_one_id', $user_two)->_and()->_eq('user_two_id', $user_one)->_clpar();
        
        $result = Conversation::getConversation($filter);

        if(sizeof($result) > 0){
            global $queryId;
            $queryId = $result[0]['id'];
            ConversationsController::getConversationById();
        }else{
            $c_conversation = new Conversation(null, $user_one, $user_two, null, null, null);
            $result_i = Conversation::insertConversation(DatabaseHelper::extractParams(Conversation::class, $c_conversation, 'insert'));
            $result_c = Conversation::getConversation(DatabaseHelper::createFilterCondition('')->_eq('id', $result_i->id));

            $converation = $result_c[0];
        }

        ResponseController::sentSuccessflyResponse($converation);
    }
}