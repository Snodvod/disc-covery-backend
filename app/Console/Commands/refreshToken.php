<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class refreshToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh spotify token';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $social = User::find(1)->socials()->where('platform', 'spotify')->first();
        $token = $social->token;
        $postUrl = 'https://accounts.spotify.com/api/token';
        $params = array(
            'grant_type' => 'authorization_code',
            'code' => $token,
            'redirect_uri' => env('SPOTIFY_REDIRECT'),
            'client_id' => env('SPOTIFY_ID'),
            'client_secret' => env('SPOTIFY_SECRET'),
        );
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($params),
            ),
        );
        $context = stream_context_create($options);
        $result = json_decode(file_get_contents($postUrl, false, $context));

        $social->token = $result->access_token;
        $social->save();


    }
}
