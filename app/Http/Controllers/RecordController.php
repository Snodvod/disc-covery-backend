<?php

namespace App\Http\Controllers;

use App\Musicfinder;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function find(Request $request)
    {
        $musicFinder = new Musicfinder();
        $result = $musicFinder->find($request->files->get('file'));

        return response()->json(['data' => $result], 200);
    }
}
