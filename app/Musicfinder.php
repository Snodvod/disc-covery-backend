<?php

namespace App;

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
        $access_key = '23ea3f93c2447461b07eb50c96ccac74';
        $access_secret = 'QLOOdjBmuI25nNHBXgw3WTnFCxHRKYBnd7VV8mp3';

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
        $cfile = \curl_file_create($file, "mp3", basename($file));
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
}
