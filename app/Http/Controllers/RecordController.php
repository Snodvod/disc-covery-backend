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
                    $res = $client->get('https://api.spotify.com/v1/search?q=' . urlencode($record->name . ' ' . $record->artist) . '&type=album');
                    $albums = collect(json_decode($res->getBody()->getContents())->albums->items);

                    if (count($albums) > 0) {
                        $album = $albums->filter(function ($album) use ($record) {
                            return strtolower($album->name) == strtolower($record->name);
                        })->first();
                        $record->spotify_id = $album->id;
                        $record->image = $album->images[1];
                        $tracks = json_decode($client->get('https://api.spotify.com/v1/albums/' . $record->spotify_id . '/tracks')->getBody()->getContents())->items;
                        $record->saveTracks($tracks);
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
        $record = Record::find($id);
        $record->tracks = $record->songs;

        foreach ($record->tracks as $track)
        {
            $track->duration = intval($track->duration);

            $seconds = ($track->duration / 1000) % 60;
            $input = floor($track->duration / 1000) / 60;

            $minutes = $track->duration % 60;
            $input = floor($track->duration / 60);

            if ($minutes < 10) { $minutes = "0".$minutes; }
            if ($seconds < 10) { $seconds = "0".$seconds; }

            $duration = $minutes.':'.$seconds;
            $track->duration = $duration;
        }

        return json_encode($record);
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
        $records = Record::select('records.*')
                            ->join('record_user', 'record_user.record_id', '=', 'records.id')
                            ->where('user_id', User::findByFbToken($request->input('fb_token'))->id)
                            ->get();
        return json_encode($records);
    }

    public function addToPlaylist()
    {
        $user = User::find(1);

        return Record::addToPlaylist($user->socials()->where('platform', 'spotify')->first()->token);
    }
}
