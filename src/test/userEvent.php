<?php

namespace Test;

require __DIR__ . '/eventModel.php';

use Test\EventModel;
use App\Models\Users;

class UserEvent extends EventModel
{
    public static function getUsers()
    {
        static::executeEvent(
            new EventModel(
                '',
                '{}',
                'users',
                'GET',
                '{}'
            )
        );
    }

    public static function insertUser()
    {
        static::executeEvent(
            new EventModel(
                '',
                '{}',
                'users',
                'POST',
                new Users(null, 'emailprueba@gmail.com', '123', null, 'student', null, null)
            )
        );
    }

    public static function getUserByAnyType()
    {
        static::executeEvent(
            new EventModel(
                '/56',
                '{}',
                'any_by_user_id',
                'GET',
                '{}'
            )
        );
    }

    public static function getUserById()
    {
        static::executeEvent(
            new EventModel(
                '/56',
                '{}',
                'user',
                'GET',
                '{}'
            )
        );
    }

    public static function deleteUser()
    {
        static::executeEvent(
            new EventModel(
                '/56',
                '{}',
                'users',
                'DELETE',
                '{}'
            )
        );
    }

    public static function updateUser()
    {
        static::executeEvent(
            new EventModel(
                '/56',
                '{}',
                'users',
                'PUT',
                '{}'
            )
        );
    }
}

