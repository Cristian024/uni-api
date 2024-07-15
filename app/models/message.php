<?php

namespace App\Models;
use App\Controllers\General\DataBaseController;
use App\Helpers\DatabaseHelper;

class Message{
    public $id;
    public $conversation_id;
    public $phrase;
    public $user_post;
    public $cdate;

    public function __construct($id, $conversation_id, $phrase, $user_post, $cdate){
        $this->id = $id;
        $this->conversation_id = $conversation_id;
        $this->phrase = $phrase;
        $this->user_post = $user_post;
        $this->cdate = $cdate;
    }

    public static function getMessage($filter){
        $sql = DatabaseHelper::createFilterRows('messages', 'm')->_all()->_cmsel()->addFilter($filter);
        return DataBaseController::executeConsult($sql);
    }
    public static function insertMessage($data){
        return DataBaseController::executeInsert('messages',Message::class,$data);
    }
}