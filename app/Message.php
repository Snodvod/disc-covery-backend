<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class Message extends Model
{
    protected function pushNew($user_id, $message_id, $record_id) {
        DB::table('message_user')->insert([
            'user_id'       => $user_id,
            'message_id'    => $message_id,
            'record_id'     => $record_id,
            'push'          => 1
        ]);
    }

    protected function addToFeed($user_id, $message_id, $record_id) {
        DB::table('message_user')->insert([
            'user_id'       => $user_id,
            'message_id'    => $message_id,
            'record_id'     => $record_id,
            'push'          => 0
        ]);
    }

    protected function getFeed($user_id) {
    	return self::select(DB::raw('messages.*, message_user.user_id'))
    				->join('message_user', 'message_user.message_id', '=', 'messages.id')
    				->join('users', 'users.id', '=', 'message_user.user_id')
    				->join('following', 'following.following_id', '=', 'users.id')
    				->where('following.follower_id', $user_id)
                    ->where('messages.push', 0)
    				->orderBy('message_user.created_at', 'desc')
    				->get();
    }
}
