<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 20/12/2016
 * Time: 14:57
 */

namespace App\Http\Controllers;

use App\Notifications\facebookPush;
use App\User;
use App\SocialAccount;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SocialController
{
    public function spotify(Request $request) {
        $data = $request->all();
        SocialAccount::add([
            'token'     => $data['token'],
            'fb_token'  => $data['fb_token'],
            'platform'  => 'spotify',
        ]);
    }

    public function twitter(Request $request) {
        $data = $request->all();
        SocialAccount::add([
            'token'         => $data['token'],
            'fb_token'      => $data['fb_token'],
            'api_user_id'   => $data['api_user_id'],
            'token_secret'  => $data['token_secret'],
            'platform'      => 'twitter',
        ]);
    }

    public function openFacebookDialog() {
        $user = User::first();
        $user->notify(new facebookPush($user));
    }

    public function tweet($twitter_token) {
        SocialAccount::tweet($twitter_token);
    }
}
