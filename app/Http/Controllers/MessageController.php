<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Message;

class MessageController extends Controller
{
    public function get($user_id) { return json_encode(Message::getFeed($user_id)); }
}
