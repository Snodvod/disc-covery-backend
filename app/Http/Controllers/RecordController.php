<?php

namespace App\Http\Controllers;

use App\Musicfinder;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function find(Request $request)
    {
        $file = $request->files->get('file');

        $musicFinder = new Musicfinder();

        $result = json_decode($musicFinder->find($file));

        if ($result->status->msg == "Success") {
            return response()->json(['data' => 'everything ok'], 200);
        }
    }
}
