<?php

namespace App\Http\Controllers;

use App\Musicfinder;
use App\Record;
use App\SocialAccount;
use App\Song;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

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
                $title = $result->metadata->music[0]->title;
                $artist = $result->metadata->music[0]->artists[0]->name;

                $results = $musicFinder->gracenote($artist, $title);

                $album = $results[0]['album_title'];
                $year = $results[0]['album_year'];

                $record = Record::where('name', $album)->first();
                if (!$record) {

                    $record = Record::create([
                        'name' => $album,
                        'artist' => $artist,
                        'year' => $year
                    ]);

                    $client = new Client();
                    $res = $client->get('https://api.spotify.com/v1/search?q=' . str_replace(' ', '+', $record->name) . '&type=album');
                    $albums = json_decode($res->getBody()->getContents())->albums->items;
                    

                    if (count($albums) > 0) {
                        foreach ($albums as $index => $album) {
                            if (strcmp($album->name, $record->name)) {
                                foreach ($album->artists as $artist) {
                                    if (strcmp($artist->name, $record->artist)) {
                                        $record->spotify_id = $album->id;
                                        $tracks = json_decode($client->get('https://api.spotify.com/v1/albums/' . $record->spotify_id . '/tracks')->getBody()->getContents())->items;
                                        $record->saveTracks($tracks);
                                        break 2;
                                    }
                                }
                            }
                        }
                    } else {
                        $record->spotify_id = null;
                    }
                    $record->save();
                    $record->users()->attach(1);
                }

                $record = User::find(1)->records()->find($record->id);
                return response()->json([
                    'twitter' => SocialAccount::isLinked('twitter'),
                    'spotify' => SocialAccount::isLinked('spotify') && !$record->pivot->spotified,
                    'result' => 1,
                ], 200);
            } else {
                return response()->json(['result' => 0], 200);
            }
        } else {
            return response()->json(['result' => 0], 200);
        }
    }

    public function findOwner($record_id)
    {
        return User::findByRecord($record_id);
    }

    public function show($id)
    {
        return json_encode(Record::find($id));
    }

    public function add($record_id)
    {
        Record::find($record_id)->add();
    }

    public function destroy($id)
    {
        Record::destroy($id);
    }

    public function myList(Request $request)
    {
        return json_encode([]);
    }

    public function addToPlaylist(Request $request)
    {
        return Record::addToPlaylist($request->input('fb_token'));
    }
}
