<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use GuzzleHttp\Client;

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
            'client_id' => env('SPOTIFY_ID'),
            'client_secret' => env('SPOTIFY_SECRET'),
            'grant_type' => 'authorization_code',
            'code' => $token,
            'redirect_uri' => env('SPOTIFY_REDIRECT'),
        );

        $client = new Client();

        $request = $client->request('POST', $postUrl, $params);
        $result = $client->send($request);


        $social->token = $result->access_token;
        $social->save();


    }
}
