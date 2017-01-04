<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class SocialAccount extends Model
{
    protected $fillable = ['token', 'user_id', 'platform'];
    public $timestamps = false;

    protected function add($token, $fb_token, $platform, $api_user_id = null) {
        if ($api_user_id == null && 'platform' == 'spotify') {

            // Send API request to get user id from Spotify
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URI, 'https://api.spotify.com/v1/me');
            curl_setopt($curl, CURLOPT_HTTPHEADER, 'Authorization: Bearer '.$token);
            $result = curl_exec($curl);
            curl_close($curl);

            $spotify_id = json_decode($result)['id'];

            $api_user_id = $spotify_id;
        }
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