<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function android()
    {
        $path = public_path(). "/apps/ForTheRecord.apk";
        return response()->download($path, 'ForTheRecord.apk');
    }
}
