<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class SocialAccount extends Model
{
    protected $fillable = ['token', 'user_id', 'platform'];
    public $timestamps = false;

    protected function add($data) {
        if (!array_key_exists('api_user_id ', $data) && 'platform' == 'spotify') {

            // Send API request to get user id from Spotify
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'https://api.spotify.com/v1/me');
            curl_setopt($curl, CURLOPT_HTTPHEADER, 'Authorization: Bearer '.$data['token']);
            $result = curl_exec($curl);
            curl_close($curl);

            $spotify_id = json_decode($result)['id'];

            $data['api_user_id'] = $spotify_id;
        }

        $data['user_id'] = User::findByFbToken($data['fb_token'])->id;
        $social = self::firstOrNew([
            'user_id'       => $data['user_id'],
            'platform'      => $data['platform'],
            'api_user_id'   => $data['api_user_id']
        ]);

        $social->token = $data['token'];
        $social->save();
    }

    protected function isLinked($platform) {
        $social = SocialAccount::where('platform', $platform)->first();
        if (isset($social->id)) { return 1; }
        return 0;
    }
}