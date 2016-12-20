<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Message;

class MessageController extends Controller
{
    public function get($user_id = false) {
        if (!$user_id) { $user_id = 1; }
        return json_encode(Message::getFeed($user_id));
    }
}
