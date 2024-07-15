<?php

namespace App\Controllers\Chat;

use App\Controllers\General\ResponseController;
use App\Helpers\DatabaseHelper;
use App\Helpers\RequestHelper;
use App\Models\Conversation;

class ConversationsController
{
    public static function getConversationById()
    {
        $id = RequestHelper::getIdParam();
        $filter = DatabaseHelper::createFilterCondition('')->_eq('id', $id);
        ResponseController::sentSuccessflyResponse(Conversation::getConversation($filter));
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
            $converation = $result[0];
        }else{
            $c_conversation = new Conversation(null, $user_one, $user_two, null);
            $result_i = Conversation::insertConversation(DatabaseHelper::extractParams(Conversation::class, $c_conversation, 'insert'));
            $result_c = Conversation::getConversation(DatabaseHelper::createFilterCondition('')->_eq('id', $result_i->id));

            $converation = $result_c[0];
        }

        ResponseController::sentSuccessflyResponse($converation);
    }
}