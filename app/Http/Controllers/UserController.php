<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

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

        $user = new User($data);

        $user->save();

        SocialAccounts::add($token, $user->id, 'facebook');
    }

    public function following() {
        return json_encode(User::find(1)->following());
    }
}
