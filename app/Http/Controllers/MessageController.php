<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Message;
use Auth;

class MessageController extends Controller
{
    public function get($user_id = false) {
        if (!$user_id) { $user_id = Auth::user()->id; }
        return json_encode(Message::getFeed($user_id));
    }
}
