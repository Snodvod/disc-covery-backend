<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class Message extends Model
{
    public function make($user_id, $message_id) {

    }

    protected function getFeed($user_id) {
    	return self::select(DB::raw('messages.*, message_user.user_id'))
    				->join('message_user', 'message_user.message_id', '=', 'messages.id')
    				->join('users', 'users.id', '=', 'message_user.user_id')
    				->join('following', 'following.following_id', '=', 'users.id')
    				->where('following.follower_id', $user_id)
    				->orderBy('message_user.created_at', 'desc')
    				->get();
    }
}
