<?php

namespace App\Controllers\Chat;

use App\Controllers\General\ResponseController;
use App\Helpers\RequestHelper;
use App\Models\Conversations;
use App\Models\Messages;
use App\Models\Filter;

class ConversationsController
{
    public static function getConversationById()
    {
        $conversation_obj = new \stdClass;
        $id = RequestHelper::getIdParam();
        $filter_c = Filter::_create()->_eq('id', $id);
        $filter_m = Filter::_create()->_eq('conversation_id', $id);

        $conversation = Conversations::_consult()->_all()->_cmsel()->_filter($filter_c)->_init();
        $count_messages = Messages::getCountMessages($filter_m);

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

        $filter = Filter::_create()->_oppar()->_eq('user_one_id', $user_one)->_and()->_eq('user_two_id', $user_two)->_clpar()
        ->_or()->_oppar()->_eq('user_one_id', $user_two)->_and()->_eq('user_two_id', $user_one)->_clpar();

        $result = Conversations::_consult()->_all()->_cmsel()->_filter($filter)->_init();

        if(sizeof($result) > 0){
            global $queryId;
            $queryId = $result[0]['id'];
            ConversationsController::getConversationById();
        }else{
            $c_conversation = new Conversations(null, $user_one, $user_two, null, null, null);
            $result_i = Conversations::_insert($c_conversation)->_init();
            $result_c = Conversations::_consult()->_all()->_cmsel()->_id($result_i->id)->_init();

            $converation = $result_c[0];
        }

        ResponseController::sentSuccessflyResponse($converation);
    }

    public static function updateConversation(){
        ResponseController::sentSuccessflyResponse(
            Conversations::_update(null)->_id(RequestHelper::getIdParam())->_init()
        );
    }
}