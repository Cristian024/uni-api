<?php

namespace App\Models;

use App\Controllers\General\DataBaseController;
use App\Helpers\DatabaseHelper;

class Messages extends Model
{
    public $id;
    public $conversation_id;
    public $phrase;
    public $user_post;
    public $cdate;
    public $state;

    public function __construct($id, $conversation_id, $phrase, $user_post, $cdate, $state)
    {
        $this->id = $id;
        $this->conversation_id = $conversation_id;
        $this->phrase = $phrase;
        $this->user_post = $user_post;
        $this->cdate = $cdate;
        $this->state = $state;
    }

    public static function getCountMessages($filter)
    {
        return Messages::_consult()->_rows('COUNT(id) AS count_messages')->_cmsel()->_filter($filter)->_init();
    }
}