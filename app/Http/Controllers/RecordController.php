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

        if ($result->status->msg == "Success") {
            return response()->json(['data' => 'everything ok'], 200);
        }
    }
}
