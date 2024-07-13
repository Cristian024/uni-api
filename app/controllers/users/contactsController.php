<?php

namespace App\Controllers\Users;

use App\Controllers\General\ResponseController;
use App\Helpers\DatabaseHelper;
use App\Helpers\RequestHelper;
use App\Models\Contact;

class ContactsController
{
    public static function getContactsByUserId()
    {
        $id = RequestHelper::getIdParam();
        $filter = DatabaseHelper::createFilterCondition('')->_eq('user_id', $id);
        ResponseController::sentSuccessflyResponse(Contact::getContacts($filter));
    }

    public static function updateContacts()
    {
        ResponseController::sentSuccessflyResponse(Contact::updateContacts(null));
    }
}