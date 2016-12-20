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

        $token = $data['token'];
        unset($data['token']);

        $user = User::firstOrNew(['email' => $data['email']])->first();

        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];
        $user->save();

        SocialAccount::add($token, $user->id, 'facebook');

    }

    public function following() {
        return json_encode(User::find(1)->following());
    }
}
