<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Twitter;

class SocialAccount extends Model
{
    protected $fillable = ['token', 'token_secret', 'user_id', 'platform', 'api_user_id', 'refresh_token'];
    public $timestamps = false;

    protected function add(array $data)
    {
        if (!array_key_exists('api_user_id', $data) && $data['platform'] == 'spotify') {
            $postfields = 'grant_type=authorization_code' .
                '&code=' . preg_replace('/#[^#]*$/', '', $data['token']) .
                '&redirect_uri=' . env('SPOTIFY_REDIRECT');


            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'https://accounts.spotify.com/api/token');
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                'Authorization: Basic ' . \base64_encode(env('SPOTIFY_ID') . ':' . env('SPOTIFY_SECRET')),
                'Content-Type: application/x-www-form-urlencoded',
            ]);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postfields);

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

            $result = curl_exec($curl);
            curl_close($curl);

            $result = json_decode($result, true);

            $data['token'] = $result['access_token'];
            $data['refresh_token'] = $result['refresh_token'];

            // Send API request to get user id from Spotify
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'https://api.spotify.com/v1/me');
            curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $data['token']]);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            $result = curl_exec($curl);
            curl_close($curl);

            $spotify_id = json_decode($result, true)['id'];

            $data['api_user_id'] = $spotify_id;
        }

        if (!array_key_exists('user_id', $data)) {
            $data['user_id'] = User::findByFbToken($data['fb_token'])->id;
        }

        $social = self::firstOrNew([
            'user_id' => $data['user_id'],
            'platform' => $data['platform'],
            'api_user_id' => $data['api_user_id']
        ]);

        $social->token = $data['token'];

        if ($data['platform'] == 'spotify') {
            $social->refresh_token = $data['refresh_token'];
        }
        if ($data['platform'] == 'twitter') {
            $social->token_secret = $data['token_secret'];
        }

        $social->save();
    }

    protected function isLinked($platform)
    {
        $user = User::where('active', true)->first();
        $social = SocialAccount::where('user_id', $user->id)->where('platform', $platform)->first();

        if (isset($social->id)) {
            return 1;
        }
        return 0;
    }

    protected function tweet($twitter_token)
    {
        $record = Record::select('records.*')
            ->join('record_user', 'record_user.record_id', '=', 'records.id')
            ->where('record_user.user_id', 1)
            ->orderBy('updated_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->first();
        $social = self::where(['platform' => 'twitter', 'token' => $twitter_token])->first();

        Twitter::reconfig(['token' => $social->token, 'secret' => $social->token_secret]);
        return Twitter::postTweet(['status' => '#ForTheRecord #ListeningTo ' . $record->name . ' by ' . $record->artist, 'format' => 'json']);
    }
}