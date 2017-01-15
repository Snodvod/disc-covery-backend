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
            'user_id' => Auth::user()->id
        ]);
    }

    public function saveTracks($tracks)
    {
        foreach ($tracks as $track) {
            $song = Song::updateOrCreate([
                'name' => $track->name,
                'duration' => $track->duration_ms,
                'spotify_id' => $track->id,
            ]);
            $record = $this;
            DB::table('record_song')->insert([
                'record_id' => $record->id,
                'song_id' => $song->id,
            ]);
        }
    }

    public function songs()
    {
        return $this->belongsToMany('App\Song');
    }

    protected function addToPlaylist($token)
    {
        $user = User::select('users.*', 'social_accounts.token', 'social_accounts.playlist_id', 'social_accounts.api_user_id AS spotify_id', 'social_accounts.id AS social_id')
            ->join('social_accounts', 'social_accounts.user_id', '=', 'users.id')
            ->where(['social_accounts.platform' => 'spotify', 'social_accounts.token' => $token])->first();

        $spotify_user_id = $user->socials()->where('platform', 'spotify')->first()->api_user_id;

        if ($user->playlist_id == null) {
            $user->playlist_id = self::makePlaylist($spotify_user_id, $token);
        }

        $record = Record::select('records.*', 'record_user.spotified', 'record_user.id AS ruid')
            ->join('record_user', 'record_user.record_id', 'records.id')
            ->join('users', 'record_user.user_id', 'users.id')
            ->where('record_user.user_id', $user->id)
            ->orderBy('updated_at', 'desc')
            ->first();

        if (!$record->spotified) {
            $tracks = Song::join('record_song', 'record_song.song_id', '=', 'songs.id')
                ->where('record_song.record_id', $record->id)->get();
            $uris = [];

            foreach ($tracks as $track) {
                array_push($uris, 'spotify:track:' . $track->spotify_id);
            }
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://api.spotify.com/v1/users/'.$spotify_user_id.'/playlists/'.$user->playlist_id.'/tracks');
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer '.$token,
                'Accept: application/json'
            ]);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['uris' => $uris]));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

            $result = curl_exec($ch);

            curl_close($ch);
            DB::table('record_user')->where('id', $record->ruid)->update(['spotified' => 1]);

            return $result;
        }
    }

    protected function makePlaylist($spotify_id, $token)
    {
        $postfields = [
            'name' => 'My Records',
            'public' => true,
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.spotify.com/v1/users/' . $spotify_id . '/playlists');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer '.$token,
            'Content-Type:application/json',
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postfields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $playlist_id = json_decode($result)->id;

        if ($httpcode == 201) {
            $social = SocialAccount::where(['token' => $token, 'platform' => 'spotify'])->first();
            $social->playlist_id = $playlist_id;
            $social->save();
            return $social->playlist_id;
        }

        return null;
    }

    public function users()
    {
        return $this->belongsToMany('App\User')->withPivot('spotified')->withTimestamps();
    }
}


