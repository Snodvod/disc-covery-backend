<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 20/12/2016
 * Time: 14:57
 */

namespace App\Http\Controllers;

use App\Record;
use App\User;
use App\SocialAccount;
use Facebook\Exceptions\FacebookSDKException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;

class SocialController
{
    public function spotify(Request $request)
    {
        $data = $request->all();
        SocialAccount::add([
            'token' => $data['token'],
            'fb_token' => $data['fb_token'],
            'platform' => 'spotify',
        ]);
    }

    public function twitter(Request $request)
    {
        $data = $request->all();
        SocialAccount::add([
            'token' => $data['token'],
            'fb_token' => $data['fb_token'],
            'api_user_id' => $data['api_user_id'],
            'token_secret' => $data['token_secret'],
            'platform' => 'twitter',
        ]);
    }

    public function openFacebookDialog(LaravelFacebookSdk $fb)
    {
        $user = User::where('active', true)->first();
        $social = $user->socials()->where('platform', 'facebook')->first();

        $record = Record::select('records.*')
            ->join('record_user', 'record_user.record_id', 'records.id')
            ->join('users', 'record_user.user_id', 'users.id')
            ->where('record_user.user_id', $user->id)
            ->orderBy('updated_at', 'desc')
            ->first();

        $linkData = [
            'link' => 'http://fortherecord.be',
            'message' => '#ForTheRecord #ListeningTo '.$record->name.' by '.$record->artist,
        ];
        try {
            $response = $fb->post('/me/feed', $linkData, $social->token);
        } catch (FacebookSDKException $e) {
            dd($e->getMessage());
        }

        return ('Posted on facebook');
    }

    public function tweet()
    {
        $user = User::where('active', true)->first();
        $twitter = $user->socials()->where('platform', 'twitter')->first();

        SocialAccount::tweet($twitter->token);

        return 'Tweeted';
    }
}
