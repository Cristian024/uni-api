<?php

namespace App\Models;
use App\Controllers\General\DataBaseController;
use App\Helpers\DatabaseHelper;

class Conversation{
    public $id;
    public $user_one_id;
    public $user_two_id;
    public $last_message;

    public function __construct($id, $user_one_id, $user_two_id, $last_message){
        $this->id = $id;
        $this->user_one_id = $user_one_id;
        $this->user_two_id = $user_two_id;
        $this->last_message = $last_message;
    }

    public static function getConversation($filter){
        $sql = DatabaseHelper::createFilterRows('conversations', 'c')->_all()->_cmsel()->addFilter($filter);
        return DataBaseController::executeConsult($sql);
    }

    public static function insertConversation($data){
        return DataBaseController::executeInsert('conversations', Conversation::class, $data);
    }
}