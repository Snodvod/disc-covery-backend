<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Auth;
use DB;
use GuzzleHttp\Client;

class Record extends Model
{
    protected $fillable = ['name', 'artist', 'year', 'image'];

    public function add()
    {
        DB::table('record_user')->insert([
            'record_id' => $this->id,
            'user_id'   => Auth::user()->id
        ]);
    }

    public function saveTracks($tracks) {
        foreach ($tracks as $track) {
            $song = Song::createOrUpdate([
                'name'          => $track['name'],
                'duration'      => $track['duration_ms'],
                'spotify_id'    => $track['id'],
            ]);

            DB::table('record_song')->insert([
                'record_id' => $this->id,
                'song_id' => $song->id,
            ]);
        }
    }

    protected function addToPlaylist($fb_token) {
        $user = User::select('users.*', 'token', 'playlist_id', 'api_user_id AS spotify_id', 'social_accounts.id AS social_id')
            ->join('social_accounts', 'social_accounts.user_id', '=', 'users.id')
            ->where(['platform' => 'spotify', 'token' => $fb_token])->first();

        if ($user->playlist_id == null) {
            self::makePlaylist($user->spotify_id);
            $user->playlist_id = SocialAccount::select('playlist_id')->find($user->social_id)->playlist_id;
        }

        $record = Record::select('records.*')
            ->join('record_user', 'record_user.user_id', 'users_id')
            ->where('record_user.user_id', $user->id)
            ->orderBy('updated_at', 'desc')
            ->get();

        $client = new Client();
        $tracks = Song::where('record_id', $record->id)->get();
        $uris = [];

        foreach ($tracks as $track) {
            $uris[] = $track->spotify_uri;
        }

        $res = $client->post('https://api.spotify.com/v1/users/'.$user->spotify_id.'/playlists/'.$track->spotify_idd.'/tracks', [
            'uris' => $uris
        ]);
    }

    protected function makePlaylist($spotify_id) {
        $client = new Client();
        $res = $client->post('https://api.spotify.com/v1/users/'.$spotify_id.'/playlists', [
            'name'      => 'My Records',
            'public'    => true,
        ]);

        if ($res->getStatusCode() == 200) {
            $social = SocialAccount::where('api_user_id', $spotify_id)->first();
            return json_encode($res->getBody());
        }
    }
}
