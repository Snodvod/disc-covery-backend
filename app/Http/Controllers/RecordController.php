<?php

namespace App\Http\Controllers;

use App\Musicfinder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RecordController extends Controller
{
    public function find(Request $request)
    {
        //$file = $request->file->get('file');

        Log::info("Request object:" . $request->all());

//        $musicFinder = new Musicfinder();
//
//        $result = $musicFinder->find($file);
//
//        Log::info($result);
//
//        $result = json_decode($result);
//
//        if ($result->status->msg == "Success") {
//            return response()->json(['data' => 'everything ok'], 200);
//        }
    }
}
