<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class Message extends Model
{
    public function make($user_id, $message_id) {

    }

    public function getFeed() {
    	return self::select('messages.*, message_user.user_id')
    				->join('message_user', 'message_user.message_id', '=', 'messages.id')
    				->join('users', 'users.id', '=', 'message_user.user_id')
    				->join('following', 'following.following_id', '=', 'users.id')
    				->where('following.follower_id', Auth::user()->id)
    				->orderBy('created_at', 'desc')
    				->get();
    }
}
