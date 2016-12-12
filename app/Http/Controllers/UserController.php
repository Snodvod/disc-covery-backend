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
}
