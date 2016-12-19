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

        return User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
        ]);
    }
}
