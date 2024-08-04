<?php

namespace App\Controllers\Users;

use App\Controllers\General\ResponseController;
use App\Helpers\RequestHelper;
use App\Models\Contacts;
use App\Models\Conversations;
use App\Models\Enterprises;
use App\Models\Filter;
use App\Models\Students;

class ContactsController
{
    public static function getContactsByUserId()
    {
        ResponseController::sentSuccessflyResponse(
            Contacts::getContacts(Filter::_create()->_eq('user_id', RequestHelper::getIdParam()))    
        );
    }

    public static function updateContacts()
    {
        ResponseController::sentSuccessflyResponse(Contacts::_update()->_id(RequestHelper::getIdParam())->_init());
    }
}