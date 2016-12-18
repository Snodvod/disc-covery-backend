<?php

namespace App\Http\Controllers;

use App\Musicfinder;
use App\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RecordController extends Controller
{
    public function find(Request $request)
    {
        $file = $request->file('file');

        $musicFinder = new Musicfinder();

        $result = $musicFinder->find($file);

        $result = json_decode($result);

        if ($result) {
            if ($result->status->msg == "Success") {

                $album = $result->metadata->music[0]->album->name;
                $artist = $result->metadata->music[0]->artists[0]->name;
                $year = $result->metadata->music[0]->release_date;

                $record = Record::create([
                    'name' => $album,
                    'artist' => $artist,
                    'year' => $year
                ]);

                

                return response()->json(['Artist' => $result->metadata->music[0]->artists[0]->name], 200);
            } else {
                return response()->json(['data' => 'Sorry nothing found'], 200);
            }
        } else {
            return response()->json(['data' => 'Sorry nothing found'], 200);
        }
    }

    public function findOwner($record_id)
    {
        return User::findByRecord($record_id);
    }

    public function show($id) { return json_encode(Record::find($id)); }
    public function add($record_id) { Record::find($record_id)->add(); }
    public function destroy($id) { Record::destroy($id); }


}
