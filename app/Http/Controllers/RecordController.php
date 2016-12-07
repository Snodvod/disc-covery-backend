<?php

namespace App\Http\Controllers;

use App\Musicfinder;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function find(Request $request)
    {
        $musicFinder = new Musicfinder();
        $result = json_decode($musicFinder->find($request->files[0]));

        return response()->json($result);
    }
}
