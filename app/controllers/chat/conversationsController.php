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
        ResponseController::sentSuccessflyResponse(Conversations::getConversationById());
    }

    public static function getConversationByUsers()
    {
        ResponseController::sentSuccessflyResponse(Conversations::getConversationByUsers(null));
    }

    public static function updateConversation(){
        ResponseController::sentSuccessflyResponse(
            Conversations::_update()->_id(RequestHelper::getIdParam())->_init()
        );
    }
}