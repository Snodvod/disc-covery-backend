<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 20/12/2016
 * Time: 14:57
 */

namespace App\Http\Controllers;

use App\SocialAccount;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SocialController
{
    public function spotify(Request $request) {
        $data = $request->all();
        SocialAccount::add([
            'token' => $data['token'],
            'fb_token' => $data['fb_token'],
            'platform' => 'spotify',
        ]);
    }

    public function openFacebookDialog() {

    }
}
