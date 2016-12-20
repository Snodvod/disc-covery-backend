<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 20/12/2016
 * Time: 16:31
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialAccount
{
    protected $fillable = ['token', 'user_id', 'platform'];
    public $timestamps = false;

    protected function add($token, $user_id, $platform) {
        $social = self::firstOrNew([
            'user_id'   => $user_id,
            'platform'  => $platform
        ]);

        $social->token = $token;
        $social->save();
    }
}