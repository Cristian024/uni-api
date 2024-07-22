<?php

namespace App\Models;

class Conversations extends Model{
    public $id;
    public $user_one_id;
    public $user_two_id;
    public $last_message;
    public $last_message_date;
    public $last_message_from;

    public function __construct($id, $user_one_id, $user_two_id, $last_message, $last_message_date, $last_message_from){
        $this->id = $id;
        $this->user_one_id = $user_one_id;
        $this->user_two_id = $user_two_id;
        $this->last_message = $last_message;
        $this->last_message_date = $last_message_date;
        $this->last_message_from = $last_message_from;
    }
}