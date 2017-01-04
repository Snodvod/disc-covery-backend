<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class SocialAccount extends Model
{
    protected $fillable = ['token', 'user_id', 'platform', 'api_user_id'];
    public $timestamps = false;

    protected function add(array $data) {
        if (!array_key_exists('api_user_id', $data) && $data['platform'] == 'spotify') {

            // Send API request to get user id from Spotify
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'https://api.spotify.com/v1/me');
            curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Bearer '.$data['token']]);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            $result = curl_exec($curl);
            curl_close($curl);

            $spotify_id = json_decode($result, true)['id'];

            $data['api_user_id'] = $spotify_id;
        }

        if (!array_key_exists('user_id', $data)) { $data['user_id'] = User::findByFbToken($data['fb_token'])->id; }
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