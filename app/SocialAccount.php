<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    protected $fillable = ['token', 'user_id', 'platform'];
    public $timestamps = false;

    protected function add($token, $user_id, $platform, $api_user_id) {
        $social = self::firstOrNew([
            'user_id'       => $user_id,
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