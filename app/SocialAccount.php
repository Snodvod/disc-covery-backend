<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    protected $fillable = ['token', 'user_id', 'platform'];
    public $timestamps = false;

    protected function add($token, $fb_token, $platform, $api_user_id) {
        $user = User::findByFbToken($fb_token);
        $social = self::firstOrNew([
            'user_id'       => $user->id,
            'platform'      => $platform,
            'api_user_id'   => $api_user_id
        ]);

        $social->token = $token;
        $social->save();
    }

    protected function isLinked($platform) {
        $social = SocialAccount::where('platform', $platform)->first();
        if (isset($social->id)) { return 1; }
        return 0;
    }
}