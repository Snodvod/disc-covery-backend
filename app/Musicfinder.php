<?php
namespace App;

use App\Gracenote\GracenoteWebAPI;

class Musicfinder
{

    public function find($file)
    {
        $http_method = "POST";
        $http_uri = "/v1/identify";
        $data_type = "audio";
        $signature_version = "1";
        $timestamp = time();
// Replace "###...###" below with your project's host, access_key and access_secret.
        $requrl = "http://eu-west-1.api.acrcloud.com/v1/identify";
        $access_key = env('ACR_KEY');
        $access_secret = env('ACR_SECRET');;

        $string_to_sign =
            $http_method . "\n" .
            $http_uri . "\n" .
            $access_key . "\n" .
            $data_type . "\n" .
            $signature_version . "\n" .
            $timestamp;

        $signature = hash_hmac("sha1", $string_to_sign, $access_secret, true);
        $signature = base64_encode($signature);
        // suported file formats: mp3,wav,wma,amr,ogg, ape,acc,spx,m4a,mp4,FLAC, etc
        // File size: < 1M , You'de better cut large file to small file, within 15 seconds data size is better
        $filesize = filesize($file);
        $cfile = \curl_file_create($file, "wav", basename($file));
        $postfields = array(
            "sample" => $cfile,
            "sample_bytes" => $filesize,
            "access_key" => $access_key,
            "data_type" => $data_type,
            "signature" => $signature,
            "signature_version" => $signature_version,
            "timestamp" => $timestamp);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $requrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;

    }

    public function gracenote($artist, $track) {
        $client_id = env('GRACENOTE_CLIENT_ID');
        $client_tag = env('GRACENOTE_CLIENT_TAG');
        $user_id = env('GRACENOTE_USER_ID');

        $api = new GracenoteWebAPI($client_id, $client_tag, $user_id);

        $track = preg_replace("/\([^)]+\)/","",$track);
        $track = preg_replace('/\[.*?\]/', '', $track);


        $results = $api->searchTrack($artist, '', $track);
        $sortedResults = collect($results)->sortBy('album_year')->values()->all();
        return $sortedResults;
    }
}
