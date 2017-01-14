<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\SocialAccount;

class UserController extends Controller
{
    public function search(Request $request)
    {
        $users = $request->input('q') != '' ? User::search($request->input('q')) : [];
        return view('users.search')->with([
            'users' => $users,
            'query' => $request->input('q')
        ]);
    }

    public function show($id) { return json_encode(User::find($id)); }

    public function destroy($id) { User::destroy($id); }

    public function create(Request $request) {
        $data = $request->all();

        // Set all users to non active
        User::all()->update(['active', false]);

        $token = $data['token'];
        unset($data['token']);

        $user = User::firstOrNew(['email' => $data['email']]);

        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];
        $user->device_token = $token;
        $user->active = true;
        $user->save();

        SocialAccount::add([
            'token'         => $token,
            'user_id'       => $user->id,
            'platform'      => 'facebook',
            'api_user_id'   => $data['api_user_id']
        ]);

    }

    public function following() {
        return json_encode(User::find(1)->following());
    }
}
